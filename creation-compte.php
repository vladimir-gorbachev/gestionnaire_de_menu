<?php
session_start();

require_once(__DIR__ . "/base-donnees.php");

$postData = $_POST;

// Vérification du formulaire soumis
if (empty($postData["email"])



    || empty($postData["nom"])
    || trim(strip_tags($postData["email"])) === ""
    || trim(strip_tags($postData["nom"])) === ""
) {
    echo "Il faut un titre et une recette pour soumettre le formulaire.";
    return;
}

$title = trim(strip_tags($postData["email"]));
$recipe = trim(strip_tags($postData["nom"]));

// Faire l'insertion en base
$insertRecipe = $mysqlClient->prepare('INSERT INTO recipes(title, recipe, author, is_enabled) VALUES (:title, :recipe, :author, :is_enabled)');
$insertRecipe->execute([
    'title' => $title,
    'recipe' => $recipe,
    'is_enabled' => 1,
    'author' => $_SESSION['LOGGED_USER']['email'],
]);

?>



<form action="./" method="POST">

    <h2>Créez votre compte</h2>
    
    <article class="form-connexion">
        <label for="email">Adresse e-mail:</label>
        <input type="email" id="email" name="email" placeholder="Adresse e-mail" required>
    </article>

    <article class="form-connexion">
        <label for="nom">Nom d'utilisateur:</label>
        <input type="text" id="nom" name="nom" placeholder="Nom d'utilisateur" required>
    </article>

    <article class="form-connexion">
        <label for="mot_de_passe">Mot de passe:</label>
        <input type="password" id="mot_de_passe" name="mot_de_passe" placeholder="Mot de passe" required>
    </article>

    <article class="form-connexion">
        <label for="confirmer-mdp">Confirmer mot de passe:</label>
        <input type="password" id="confirmer-mdp" name="confirmer-mdp" 
        placeholder="Confirmer mot de passe">
    </article>

    <input type="submit" value="Créer le compte">

</form>