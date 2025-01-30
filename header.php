<header>
    <nav>
        <ul>
            <li class="li-logo-mobile"><a href="index.php"><img src ="img\logo_responsive.png" alt="logo responsive"></a></li>
            <li class="li-logo"><a href="index.php"><img src="img\logo.png" alt="logo"></a></li>
            <li class="li-connexion-mobile"><a href="connexion.php"><img src="img\User.png" alt="icone connexion"></a></li>
            <li class="li-connexion">
            <?php if (!isset($_SESSION["utilisateur-connecte"])) : ?>
                <?php echo '<a href="connexion.php">Connexion</a>' ?>
            <?php else : ?>
                <?php echo '<a href="deconnexion.php">Déconnexion</a>' ?>
            <?php endif; ?>
            </li>
        </ul>
    </nav>
</header>