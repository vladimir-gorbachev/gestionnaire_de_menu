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
            $_SESSION["succesMessage"] = "Votre menu a bien été ajouté !";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="description" content=" ">
    <meta name="keywords" content="HTML, CSS, JavaScript">
    <meta name="author" content="Noa Cengarle, Armelle Pouzioux, Vladimir Gorbachev">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://kit.fontawesome.com/ecde10fa93.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="./style.css?v=<?php echo time(); ?>">
    <link rel="icon" href="./img/favicon.ico" type="image/x-icon">
    <title>Plat'form</title>
</head>
<body>
    <?php require_once(__DIR__ . "/header.php"); ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
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

    <?php require_once(__DIR__ . "/footer.php"); ?>
</body>
</html>
