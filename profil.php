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
    <link rel="icon" href="./img/favicon.png" type="image/x-icon">
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

    // Vérifier si le formulaire a été soumis pour modifier le nom d'utilisateur
    if (isset($_POST['modifier_nom_utilisateur'])) {
        // Récupérer les nouvelles valeurs
        $nouveau_nom_utilisateur = $_POST['nom_utilisateur'];
        $nouvel_email = $_POST['email'];

        // Mettre à jour la base de données
        $sql = "UPDATE utilisateurs SET nom_utilisateur = :nom_utilisateur, email = :email WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nom_utilisateur' => $nouveau_nom_utilisateur,
            ':email' => $nouvel_email,
            ':id' => $utilisateur_id
        ]);

        // Mettre à jour la session avec les nouvelles valeurs
        $_SESSION["utilisateur-connecte"]["nom_utilisateur"] = $nouveau_nom_utilisateur;
        $_SESSION["utilisateur-connecte"]["email"] = $nouvel_email;

        // Rediriger pour éviter la resoumission du formulaire
        header("Location: profil.php");
    exit();
    }
    
    // Vérifier si le formulaire a été soumis pour supprimer le profil
    if (isset($_POST['supprimer_profil'])) {
        // Supprimer l'utilisateur de la base de données
        $sql = "DELETE FROM utilisateurs WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $utilisateur_id]);

        // Détruire la session
        session_destroy();

        // Rediriger vers la page d'accueil ou de connexion
        header("Location: index.php"); // Remplacez "index.php" par la page de votre choix
        exit();
    }

    ?>

    <h1>Profil de <?= htmlspecialchars($nom_utilisateur) ?></h1>

    
        
        <form method="POST" action="profil.php" class="form-connexion">
            <label>Email :</label>
            <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" readonly required>

            <label>Nom d'utilisateur :</label> 
            <input type="text" name="nom_utilisateur" value="<?= htmlspecialchars($nom_utilisateur) ?>" required>
            <input type="submit" name="modifier_nom_utilisateur" value="Modifier nom d'utilisateur"> </button> 
            
            <input type="submit" id="supprimer_profil_bouton" name="supprimer_profil" value="supprimer profil">
                  
        </form>
        <li class="li-connexion"> <?php echo '<a href="deconnexion.php" >Déconnexion</a>' ?></li>


    <?php include 'footer.php'; ?>
</body>
</html>

