<?php
session_start();
require_once(__DIR__ . "/base-donnees.php");
require_once(__DIR__ . "/est-connecte.php");

if (!isset($_GET["menu_id"])) {
    die("Erreur lors de la création du menu.");
}

$menu_id = $_GET["menu_id"];

// Récupération des informations actuelles du menu
$query = "SELECT * FROM menu WHERE id = :menu_id";
$stmt = $pdo->prepare($query);
$stmt->execute([":menu_id" => $menu_id]);
$menu = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$menu) {
    die("Menu non trouvé.");
}

// Récupération des entrées, plats et desserts
$query = "SELECT id, nom FROM plats WHERE categorie_id = 4";
$entrees = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);

$query = "SELECT id, nom FROM plats WHERE categorie_id = 5";
$plats = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);

$query = "SELECT id, nom FROM plats WHERE categorie_id = 6";
$desserts = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST["nom"];
    $entree_id = $_POST["entree"];
    $plat_id = $_POST["plat"];
    $dessert_id = $_POST["dessert"];
    $prix = $_POST["prix"];

    $sql = "UPDATE menu SET nom = :nom, entree_id = :entree_id, plat_id = :plat_id, dessert_id = :dessert_id, prix = :prix WHERE id = :menu_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ":nom" => $nom,
        ":entree_id" => $entree_id,
        ":plat_id" => $plat_id,
        ":dessert_id" => $dessert_id,
        ":prix" => $prix,
        ":menu_id" => $menu_id
    ]);
    
    $_SESSION["modificationMenu"] = "Le menu a bien été mis à jour !";
    header("Location: creation-menu.php");
    exit();
}
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
    <title>Modifier le menu</title>
</head>
<body>
<?php require_once(__DIR__ . "/header.php"); ?>

    <h2>Modifier le menu</h2>
    <form action="" method="POST" class="form">
        <label for="nom">Nom du menu :</label>
        <input type="text" id="nom" name="nom" required value="<?= htmlspecialchars($menu['nom']) ?>">

        <label for="entree">Entrée :</label>
        <select id="entree" name="entree" required>
            <?php foreach ($entrees as $entree): ?>
                <option value="<?= $entree['id'] ?>" <?= ($menu['entree_id'] == $entree['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($entree['nom']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="plat">Plat :</label>
        <select id="plat" name="plat" required>
            <?php foreach ($plats as $plat): ?>
                <option value="<?= $plat['id'] ?>" <?= ($menu['plat_id'] == $plat['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($plat['nom']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="dessert">Dessert :</label>
        <select id="dessert" name="dessert" required>
            <?php foreach ($desserts as $dessert): ?>
                <option value="<?= $dessert['id'] ?>" <?= ($menu['dessert_id'] == $dessert['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($dessert['nom']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="prix">Prix :</label>
        <input type="number" id="prix" name="prix" min="0" required value="<?= htmlspecialchars($menu['prix']) ?>">

        <input type="submit" value="Modifier">
    </form>
    
    <?php require_once(__DIR__ . "/footer.php"); ?>
</body>
</html>