<?php
session_start();
require_once(__DIR__ . "/base-donnees.php");
require_once(__DIR__ . "/verif-activite.php");
?>

<!DOCTYPE html>
<html lang="fr ">
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
    <title>Plat'form - accueil</title>
</head>
<body>
    <!-- Entête du site -->
    <?php require_once(__DIR__ . "/header.php"); ?>

    <!-- Si ajout de recette, on affiche un message de succès -->
    <?php if (isset($_SESSION["ajoutRecette"])) : ?>
        <article class="alerte alerte-succes" role="alert">
            <?php echo $_SESSION["ajoutRecette"]; 
            unset($_SESSION["ajoutRecette"]); // Réinitialisation du message ?>
        </article>
    <?php endif; ?>

    <!-- Si suppression de recette, on affiche un message de succès -->
    <?php if (isset($_SESSION["suppressionRecette"])) : ?>
        <article class="alerte alerte-succes" role="alert">
            <?php echo $_SESSION["suppressionRecette"];
            unset($_SESSION["suppressionRecette"]); ?>
        </article>
    <?php endif; ?>

    <section class="onglets">
        <h1></h1>
        <a href="recettes_de_chef.php" class="onglet">
            <img src="img/ONGLET DECOUVREZ.png" alt="Découvrez nos recettes de Chef.fes">
        </a>

        <a href="creation-recette.php" class="onglet">
            <img src="img/ONGLET CREEZ.png" alt="Créez vos propres recettes">
        </a>

        <a href="creation-menu.php" class="onglet">
            <img src="img/ONGLET ORGANISEZ.png" alt="Organisez vos menus">
        </a>
    </section>

    <!-- Bas de page du site -->
    <?php require_once(__DIR__ . "/footer.php"); ?>
</body>
</html>