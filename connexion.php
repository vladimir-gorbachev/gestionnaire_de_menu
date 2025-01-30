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
    <link rel="icon" href="./images/favicon.ico" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">

    <title>Plat'form - Connexion</title>
</head>
<body>
    <!-- inclusion de l'entête du site -->
    <?php require_once(__DIR__ . "/header.php"); ?>

    <?php if (!isset($_SESSION["LOGGED_USER"])) : ?>

    <form action="./envoyer-connexion.php" method="POST">

        <!-- si message d'erreur, on l'affiche -->
        <?php if (isset($_SESSION["LOGIN_ERROR_MESSAGE"])) : ?>

            <article class="alerte alerte-erreur" role="alert">
                <?php echo $_SESSION["LOGIN_ERROR_MESSAGE"];
                unset($_SESSION["LOGIN_ERROR_MESSAGE"]); ?>
            </article>

        <?php endif; ?>

        <h2>Connexion à votre compte</h2>
        
        <article class="form-connexion">
            <label for="email">Adresse e-mail:</label>
            <input type="email" id="email" name="email" placeholder="Adresse e-mail" required>
        </article>

        <article class="form-connexion">
            <label for="mot_de_passe">Mot de passe:</label>
            <input type="password" id="mot_de_passe" name="mot_de_passe" placeholder="Mot de passe" 
            required>
        </article>

        <input type="submit" value="Se connecter">
        <a href="#">Mot de passe oublié ?</a>

        <a href="./creation-compte.php">Pas encore de compte ? C'est par ici !</a>

    </form>

<!-- Si utilisateur/trice bien connecté.e, on affiche un message de succès -->
    <?php else : ?>
    <?php if (isset($_SESSION["LOGGED_USER"]["nom_utilisateur"])) : ?>

        <article class="alerte alerte-succes" role="alert">
            Bonjour <?php echo $_SESSION["LOGGED_USER"]["nom_utilisateur"]; ?> !
        </article>
        
    <?php endif; ?>
    <?php endif; ?>

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