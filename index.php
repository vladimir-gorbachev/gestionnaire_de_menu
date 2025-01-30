<?php
session_start();
require_once(__DIR__ . "/base-donnees.php")
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
    
    <link rel="stylesheet" href="./style.css?v=<?php echo time(); ?>">
    <link rel="icon" href="./img/favicon.png" type="image/x-icon">
    <title>Plat'form</title>
</head>
<body>
    <!-- inclusion de l'entête du site -->
    <?php require_once(__DIR__ . "/header.php"); ?>

    <!-- Si utilisateur/trice bien connecté.e, on affiche un message de succès -->
    <?php if (isset($_SESSION["utilisateur-connecte"]["nom_utilisateur"])) : ?>
        <article class="alerte alerte-succes" role="alert">
            Bonjour <?php echo $_SESSION["utilisateur-connecte"]["nom_utilisateur"]; ?> !
        </article>
    <?php endif; ?>

    <section class="onglets">
        <a href="recettes_de_chef.php" class="onglet">
            <img src="img/ONGLET DECOUVREZ.png" alt="Découvrez nos recettes de Chef.fes">
        </a>

        <a href="link2.php" class="onglet">
            <img src="img/ONGLET CREEZ.png" alt="Créez vos propres recettes">
        </a>

        <a href="link3.php" class="onglet">
            <img src="img/ONGLET ORGANISEZ.png" alt="Organisez vos menus">
        </a>
    </section>

    <!-- inclusion du bas de page du site -->
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