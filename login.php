<?php if (!isset($_SESSION["LOGGED_USER"])) : ?>

    <form action="submit_login.php" method="POST">

        <!-- si message d'erreur, on l'affiche -->
        <?php if (isset($_SESSION["LOGIN_ERROR_MESSAGE"])) : ?>

            <article class="alert alert-danger" role="alert">
                <?php echo $_SESSION["LOGIN_ERROR_MESSAGE"];
                unset($_SESSION["LOGIN_ERROR_MESSAGE"]); ?>
            </article>

<?php endif; ?>
    
        <h2>Connexion à votre compte</h2>
        
        <article class="form-connexion">
            <label for="email">Adresse e-mail:</label>
            <input type="email" id="email" name="email" placeholder="Adresse e-mail">
        </article>

        <article class="form-connexion">
            <label for="mdp">Mot de passe:</label>
            <input type="password" id="mdp" name="mdp" placeholder="Mot de passe">
        </article>

        <input type="submit" value="Se connecter">
        <a href="#">Mot de passe oublié ?</a>

        <a href="./creation.php">Pas encore de compte ? C'est par ici !</a>

    </form>

<!-- Si utilisateur/trice bien connecté.e, on affiche un message de succès -->
<?php else : ?>
    <article class="alert alert-success" role="alert">
        Bonjour <?php echo $_SESSION["LOGGED_USER"]["email"]; ?> !
    </article>
<?php endif; ?>