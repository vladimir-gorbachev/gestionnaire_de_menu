<header>
    <nav class="navbar">
        <article class="nav-link">
            <ul>
                <li class="li-logo-mobile"><a href="index.php"><img src ="img\logo_responsive.png" alt="logo responsive"></a></li>
                <li class="li-logo"><a href="index.php"><img src="img\logo.png" alt="logo"></a></li>

                <!-- Si utilisateur/trice bien connecté.e, on affiche le menu, un message d'accueil 
                 et bouton déconnexion -->
            <?php if (isset($_SESSION["utilisateur-connecte"]["nom_utilisateur"])) : ?>
                <li><a href="recettes_de_chef.php">Découvrez</a></li>
                <li><a href="creation-recette.php">Créez</a></li>
                <li><a href="creation-menu.php">Organisez</a></li>
                <li class="li-connexion"><a href="profil.php">
                    Bonjour <?php echo $_SESSION["utilisateur-connecte"]["nom_utilisateur"]; ?></a>
                    <?php echo '<a href="deconnexion.php">Déconnexion</a>' ?>
                </li>
            <?php else : ?>
                <li class="li-connexion">
                    <?php echo '<a href="./connexion.php">Connexion</a>' ?>
                </li>
            <?php endif; ?>
            </ul>
        </article>
        <!-- <article class="responsive">
            <input type="checkbox" id="menu-hamburger">
            <label for="menu-hamburger"></label>
        </article> -->
    </nav>
</header>


    