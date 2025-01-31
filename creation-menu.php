<?php
session_start();
require_once(__DIR__ . "/base-donnees.php");
require_once(__DIR__ . "/est-connecte.php");

// Récupération des entrées
$query = "SELECT id, nom FROM plats WHERE categorie_id = 4";
$stmt = $pdo->prepare($query);
$stmt->execute();
$entrees = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupération des plats
$query1 = "SELECT id, nom FROM plats WHERE categorie_id = 5";
$stmt1 = $pdo->prepare($query1);
$stmt1->execute();
$plats = $stmt1->fetchAll(PDO::FETCH_ASSOC);

// Récupération des desserts
$query2 = "SELECT id, nom FROM plats WHERE categorie_id = 6";
$stmt2 = $pdo->prepare($query2);
$stmt2->execute();
$desserts = $stmt2->fetchAll(PDO::FETCH_ASSOC);

$nom = "";
$nomErr = "";

function test_saisie($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["supprimerMenu"])) {
        $menu_id = $_POST["supprimerMenu"];
        $sql = "DELETE FROM menu WHERE id = :menu_id";
        $req = $pdo->prepare($sql);
        $req->execute([":menu_id" => $menu_id]);
    } elseif (isset($_POST["nom"])) {
        if (empty($_POST["nom"])) {
            $nomErr = "Un nom de menu est requis pour la création.";
        } else {
            $nom = test_saisie($_POST["nom"]);
        }
    
        if (!empty($nom) && isset($_POST["entree"], $_POST["plat"], $_POST["dessert"], $_POST["prix"])) {
            $sql = "INSERT INTO menu(nom, entree_id, plat_id, dessert_id, prix, utilisateur_id) 
                    VALUES (:nom, :entree_id, :plat_id, :dessert_id, :prix, :utilisateur_id)";
            $req = $pdo->prepare($sql);
            
            if ($req->execute([
                ":nom" => $nom,
                ":entree_id" => $_POST["entree"],
                ":plat_id" => $_POST["plat"],
                ":dessert_id" => $_POST["dessert"],
                ":prix" => $_POST["prix"],
                ":utilisateur_id" => $_SESSION["utilisateur-connecte"]["id"]
            ])) {
                $_SESSION["ajoutMenu"] = "Votre menu a bien été ajouté !";
            }
        }
    }
}

// Récupération des menus créés avec les noms des plats associés
$queryMenus = "SELECT menu.id, menu.nom, menu.prix, 
                entree.nom AS entree_nom, plat.nom AS plat_nom, dessert.nom AS dessert_nom 
                FROM menu 
                JOIN plats AS entree ON menu.entree_id = entree.id 
                JOIN plats AS plat ON menu.plat_id = plat.id 
                JOIN plats AS dessert ON menu.dessert_id = dessert.id";
$stmtMenus = $pdo->prepare($queryMenus);
$stmtMenus->execute();
$menus = $stmtMenus->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Gestionnaire de menu pour restaurateurs">
    <meta name="keywords" content="HTML, CSS, JavaScript">
    <meta name="author" content="Noa Cengarle, Armelle Pouzioux, Vladimir Gorbachev">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://kit.fontawesome.com/ecde10fa93.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="./style.css?v=<?php echo time(); ?>">
    <link rel="icon" href="./img/favicon.png" type="image/x-icon">
    <title>Création de menu</title>
</head>
<body>
    <?php require_once(__DIR__ . "/header.php"); ?>

    <!-- Si ajout de menu, on affiche un message de succès -->
    <?php if (isset($_SESSION["ajoutMenu"])) : ?>
        <article class="alerte alerte-succes" role="alert">
            <?php echo $_SESSION["ajoutMenu"]; 
            unset($_SESSION["ajoutMenu"]); // Réinitialisation du message ?>
        </article>
    <?php endif; ?>

    <!-- Si modification de menu, on affiche un message de succès -->
    <?php if (isset($_SESSION["modificationMenu"])) : ?>
        <article class="alerte alerte-succes" role="alert">
            <?php echo $_SESSION["modificationMenu"]; 
            unset($_SESSION["modificationMenu"]); // Réinitialisation du message ?>
        </article>
    <?php endif; ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="form">
        <h2>Créez votre menu</h2>

        <label for="nom">Nom du Menu:</label>
        <input type="text" id="nom" name="nom" required value="<?php echo htmlspecialchars($nom); ?>">
        <?php if (!empty($nomErr)) echo "<p class='erreur'>$nomErr</p>"; ?>

        <label for="entree">Entrée :</label>
        <select id="entree" name="entree" required>
            <?php foreach ($entrees as $entree) echo "<option value='{$entree['id']}'>{$entree['nom']}</option>"; ?>
        </select>

        <label for="plat">Plat :</label>
        <select id="plat" name="plat" required>
            <?php foreach ($plats as $plat) echo "<option value='{$plat['id']}'>{$plat['nom']}</option>"; ?>
        </select>

        <label for="dessert">Dessert :</label>
        <select id="dessert" name="dessert" required>
            <?php foreach ($desserts as $dessert) echo "<option value='{$dessert['id']}'>{$dessert['nom']}</option>"; ?>
        </select>

        <label for="prix">Prix en €:</label>
        <input type="number" id="prix" name="prix" min="0" required>

        <input type="submit" value="Créer mon menu">
    </form>

    <h2>Menus créés :</h2>
    <?php if (!empty($menus)): ?>
        <div class="onglets">
            <?php foreach ($menus as $menu): ?>
                <div class="onglet">
                    <h2><?= htmlspecialchars($menu['nom']) ?></h2>
                    <p>Entrée<br> <?= htmlspecialchars($menu['entree_nom']) ?></p>
                    <p>Plat<br> <?= htmlspecialchars($menu['plat_nom']) ?></p>
                    <p>Dessert<br> <?= htmlspecialchars($menu['dessert_nom']) ?></p>
                    <p>Prix: <?= htmlspecialchars($menu['prix']) ?> €</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                        <input type="hidden" name="supprimerMenu" value="<?= $menu['id'] ?>">
                        <input type="submit" value="Supprimer">
                    </form>
                    <form action="modifier-menu.php" method="GET" style="display:inline;">
                        <input type="hidden" name="menu_id" value="<?= $menu['id'] ?>">
                        <input type="submit" value="Modifier">
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>Aucun menu créé pour le moment.</p>
    <?php endif; ?>

    <?php require_once(__DIR__ . "/footer.php"); ?>
</body>
</html>
