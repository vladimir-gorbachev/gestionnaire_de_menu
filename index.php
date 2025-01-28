<?php
session_start();
require_once(__DIR__ . "/database.php")
?>

<!DOCTYPE html>
<html lang=" ">
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
    <title>Plat'form</title>
</head>
<body>
    <!-- inclusion de l'entête du site -->
    <?php require_once(__DIR__ . "/header.php"); ?>

    <!-- Formulaire de connexion -->
    <?php require_once(__DIR__ . "/login.php"); ?>

    <main>
        <h2>Welcome to My Website</h2>
        <img src="./images/ " alt=" " aria-label=" " class=" ">
    </main>

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