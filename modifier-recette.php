<?php
session_start();
require_once(__DIR__ . "/base-donnees.php");
require_once(__DIR__ . "/est-connecte.php");

$sql = 'SELECT * FROM plats WHERE plats.id = $_GET["plat_id"]';

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

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" 
    enctype="multipart/form-data">

        <h2>Modifiez votre recette</h2>

        <article class="form-connexion">
            <label for="nom">Nom de la recette:<?php echo $_GET["plat_id"] ?></label>
            <input type="text" id="nom" name="nom" placeholder="Nom de la recette" required>
        </article>

        <article class="form-connexion">
            <input type="radio" id="entree" name="categorie" value="4" checked>
            <label for="entree">Entrée</label>
            <input type="radio" id="plat" name="categorie" value="5">
            <label for="plat">Plat principal</label>
            <input type="radio" id="dessert" name="categorie" value="6">
            <label for="dessert">Dessert</label>
        </article>

        <article class="form-connexion">
            <label for="prix">Prix en €:</label>
            <input type="number" id="prix" name="prix" min="0" placeholder="Prix en €">
        </article>

        <article class="form-connexion">
            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>
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