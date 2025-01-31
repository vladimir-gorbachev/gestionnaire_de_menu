<header>
    <nav class="navbar">
        <ul>
            <li class="logo"><a href="index.php"><img src="img\logo.png" alt="logo"></a></li>

            <!-- Si utilisateur/trice bien connecté.e, on affiche le menu, un message d'accueil 
                et bouton déconnexion -->
        <?php if (isset($_SESSION["utilisateur-connecte"]["nom_utilisateur"])) : ?>
            <li><a href="recettes_de_chef.php">Découvrez</a></li>
            <li><a href="creation-recette.php">Créez</a></li>
            <li><a href="creation-menu.php">Organisez</a></li>
            <li class="li-connexion"><a href="profil.php">
                Bonjour <?php echo $_SESSION["utilisateur-connecte"]["nom_utilisateur"]; ?></a>
            </li>
        <?php else : ?>
            <li class="li-connexion">
                <?php echo '<a href="./connexion.php">Connexion</a>' ?>
            </li>
        <?php endif; ?>
        </ul>
    </nav>
</header>