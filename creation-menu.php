<?php
session_start();
require_once(__DIR__ . "/base-donnees.php");
require_once(__DIR__ . "/est-connecte.php");

$query = "SELECT plats.nom FROM plats INNER JOIN categories WHERE plats.categorie_id = categories.id AND plats.categorie_id = 4";
$stmt=$pdo->prepare($query);
$stmt -> execute();
$entrees=$stmt-> fetchAll(PDO::FETCH_ASSOC);

$query1 = "SELECT plats.id, plats.nom FROM plats INNER JOIN categories WHERE plats.categorie_id = categories.id AND plats.categorie_id = 5";
$stmt1=$pdo->prepare($query1);
$stmt1 -> execute();
$plats=$stmt1-> fetchAll(PDO::FETCH_ASSOC);

$query2 = "SELECT plats.nom FROM plats INNER JOIN categories WHERE plats.categorie_id = categories.id AND plats.categorie_id = 6";
$stmt2=$pdo->prepare($query2);
$stmt2 -> execute();
$desserts=$stmt2-> fetchAll(PDO::FETCH_ASSOC);

$nom  = "";
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
    }
    else {
        $nom = test_saisie($_POST["nom"]);
    }

$sql = "INSERT INTO menu(nom, entree_id, plat_id, dessert_id, prix, utilisateur_id) 
    VALUES (:nom, :entree_id, :plat_id, :dessert_id, :prix, :utilisateur_id)";
    $req = $pdo->prepare($sql);
    if ($req ->execute([":nom"=>$nom, ":categorie_id"=> $_POST["categorie"], ":prix"=>$_POST["prix"], 
    ":description"=>$description, ":image"=>$_POST["photo"], 
    ":utilisateur_id" =>$_SESSION["utilisateur-connecte"]["id"]])) {
        $_SESSION["succesMessage"] = "Votre recette a bien été ajoutée !";
        $nom = $description = "";
        header("Location: index.php");
        exit();
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

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" 
    enctype="multipart/form-data">

        <h2>Créez votre menu</h2>

        <article class="form-connexion">
            <label for="nom">Nom du Menu:</label>
            <input type="text" id="nom" name="nom" placeholder="Nom du menu" required 
            value="<?php echo htmlspecialchars($nom);?>">

            <?php if (!empty($nomErr)) : ?>
                <p class="erreur"><?php echo $nomErr;?></p>
            <?php endif; ?>
        </article>

        <label for="entree">Entrée :</label>
        <input list="entrees" id="entree" name="entree" required>
        <datalist id="entrees">
            <?php foreach($entrees as $entree) : ?>
                <option value="<?php echo $entree["nom"];?>">
            <?php endforeach; ?>
        </datalist>

        <label for="plat">Plat :</label>
        <input list="plats" id="plat" name="plat" required>
        <datalist id="plats">
            <?php foreach($plats as $plat) : ?>
                <option value="<?php $plat["id"];?>"><?php echo $plat["nom"];?></option>
            <?php endforeach; ?>
        </datalist>

        <label for="entree">Desserts :</label>
        <input list="desserts" id="dessert" name="dessert" required>
        <datalist id="desserts">
            <?php foreach($desserts as $dessert) : ?>
                <option value="<?php echo $dessert["nom"];?>">
            <?php endforeach; ?>
        </datalist>

        <article class="form-connexion">
            <label for="prix">Prix en €:</label>
            <input type="number" id="prix" name="prix" min="0" placeholder="Prix en €">
        </article>


        <input type="hidden" id="utilisateur_id" name="utilisateur_id" 
        value="<?php echo $_SESSION["utilisateur-connecte"]["id"] ?>">

        <input type="submit" value="Créer mon menu">

    </form>

    <?php require_once(__DIR__ . "/footer.php"); ?>
</body>

<script>
    const menuHamburger = document.querySelector("#menu-hamburger")
    const navLinks = document.querySelector(".nav-link")

    menuHamburger.addEventListener("click",()=>{
    navLinks.classList.toggle("mobile-menu")
    })
</script>
</html>