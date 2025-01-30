<header>
    <nav>
        <ul>
            <li class="li-logo-mobile"><a href="index.php"><img src ="img\logo_responsive.png" alt="logo responsive"></a></li>
            <li class="li-logo"><a href="index.php"><img src="img\logo.png" alt="logo"></a></li>
            <li class="li-connexion-mobile"><a href="connexion.php"><img src="img\User.png" alt="icone connexion"></a></li>

            <!-- Si utilisateur/trice bien connecté.e, on affiche un message de succès -->
            <?php if (isset($_SESSION["utilisateur-connecte"]["nom_utilisateur"])) : ?>
                <li><a href="recettes_de_chef.php">Découvrez</a></li>
                <li><a href="creation-recette.php">Créez</a></li>
                <li><a href="creation-menu.php">Organisez</a></li>
                <article class="bonjour">
                    Bonjour <?php echo $_SESSION["utilisateur-connecte"]["nom_utilisateur"]; ?>
                </article>
                <li class="li-connexion">
                    <?php echo '<a href="deconnexion.php">Déconnexion</a>' ?>
                </li>
            <?php else : ?>
                <li class="li-connexion">
                    <?php echo '<a href="connexion.php">Connexion</a>' ?>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</header>


    