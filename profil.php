<?php
session_start();
require_once(__DIR__ . "/base-donnees.php")
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="profil.css">
</head>

<body>
    <?php require_once(__DIR__ . "/header.php");?>

    <?php
    // Vérifier si l'utilisateur est connecté
    if (!isset($_SESSION["utilisateur-connecte"])) {
    die("Utilisateur non connecté.");
}

    // Récupération des informations de l'utilisateur
    $utilisateur = $_SESSION["utilisateur-connecte"];
    $utilisateur_id = $utilisateur["id"];
    $nom_utilisateur = $utilisateur["nom_utilisateur"];
    $email = $utilisateur["email"];

    ?>

    <h1>Profil de <?= htmlspecialchars($nom_utilisateur) ?></h1>
        
        <form method="POST" action="profil.php">
            <input type="hidden" name="utilisateur_id" value="<?= $utilisateur_id ?>">

            <label>Nom d'utilisateur :</label>
            <input type="text" name="nom_utilisateur" value="<?= htmlspecialchars($nom_utilisateur) ?>" required>
            
            <button type="submit" name="modifier_profil">Modifier nom d'utilisateur </button>
            <label>Email :</label>
            <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" required>

            <button type="submit" name="modifier_profil">Modifier email</button>
            
            <label>Nouveau mot de passe :</label>
            <input type="password" name="nouveau_mot_de_passe" placeholder="Laisser vide pour ne pas changer">
            
            <button type="submit" name="modifier_profil">Modifier mot de passe</button>
            <?php echo '<a href="deconnexion.php">Déconnexion</a>' ?>
            <button type="submit" name="modifier_profil">supprimer profil</button>
        </form>


    <?php include 'footer.php'; ?>
</body>
</html>

