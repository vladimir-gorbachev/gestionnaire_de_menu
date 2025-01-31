<?php
session_start();
require_once(__DIR__ . "/base-donnees.php");
require_once(__DIR__ . "/est-connecte.php");

$plat_id = $_GET["plat_id"];
$nom = $categorie_id = $prix = $description = "";

$sql = "SELECT * FROM plats WHERE plats.id = $plat_id";
$req = $pdo->prepare($sql);
$req->execute();
$plat = $req->fetch(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "UPDATE plats SET nom = $nom, categorie_id = $categorie_id, prix = $prix, description = $description
    WHERE plat_id = $plat_id";
    $req = $pdo->prepare($sql);
    if ($req ->execute()) {
        $_SESSION["succesMessage"] = "Votre recette a bien été modifiée !";
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
    <title>Modifiez votre recette</title>
</head>
<body>
    <?php require_once(__DIR__ . "/header.php"); ?>

    <!-- Si modification de recette, on affiche un message de succès -->
    <?php if (isset($_SESSION["succesMessage"])) : ?>
        <article class="alerte alerte-succes" role="alert">
            <?php echo $_SESSION["succesMessage"]; ?>
        </article>
    <?php endif; ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" 
    enctype="multipart/form-data">

        <h2>Modifiez votre recette</h2>

        <article class="form-connexion">
            <label for="nom">Nom de la recette:</label>
            <input type="text" id="nom" name="nom" placeholder="<?php echo $plat["nom"] ?>" 
            value="">
        </article>

        <article class="form-connexion">
            <?php if ($plat["categorie_id"] == 4) : ?>
                <input type="radio" id="entree" name="categorie" value="4" <?php echo "checked"; ?>>
                <label for="entree">Entrée</label>
                <input type="radio" id="plat" name="categorie" value="5">
                <label for="plat">Plat principal</label>
                <input type="radio" id="dessert" name="categorie" value="6">
                <label for="dessert">Dessert</label>
            <?php endif ; ?>
            <?php if ($plat["categorie_id"] == 5) : ?>
                <input type="radio" id="entree" name="categorie" value="4">
                <label for="entree">Entrée</label>
                <input type="radio" id="plat" name="categorie" value="5" <?php echo "checked"; ?>>
                <label for="plat">Plat principal</label>
                <input type="radio" id="dessert" name="categorie" value="6">
                <label for="dessert">Dessert</label>
            <?php endif ; ?>
            <?php if ($plat["categorie_id"] == 6) : ?>
                <input type="radio" id="entree" name="categorie" value="4">
                <label for="entree">Entrée</label>
                <input type="radio" id="plat" name="categorie" value="5">
                <label for="plat">Plat principal</label>
                <input type="radio" id="dessert" name="categorie" value="6" <?php echo "checked"; ?>>
                <label for="dessert">Dessert</label>
            <?php endif ; ?>
        </article>

        <article class="form-connexion">
            <label for="prix">Prix en €:</label>
            <input type="number" id="prix" name="prix" min="0" placeholder="<?php echo $plat["prix"] ?>" 
            value="">
        </article>

        <article class="form-connexion">
            <label for="description">Description:</label>
            <textarea id="description" name="description" 
            placeholder="<?php echo $plat["description"] ?>"></textarea>
        </article>

        <article class="form-connexion">
            <label for="photo">Photo:</label>
            <input type="file" id="photo" name="photo" accept=".jpg, .jpeg, .png, .webp, .svg">
        </article>

        <input type="hidden" id="utilisateur_id" name="utilisateur_id" 
        value="<?php echo $_SESSION["utilisateur-connecte"]["id"] ?>">

        <input type="submit" value="Modifier ma recette">

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