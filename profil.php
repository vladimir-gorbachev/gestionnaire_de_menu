<?php
session_start();
require_once(__DIR__ . "/base-donnees.php")
?>

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

        $_SESSION["modificationProfil"] = "Votre profil a bien été modifié !";
        // Rediriger pour éviter la re-soumission du formulaire
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

        // Rediriger vers la page d'accueil
        header("Location: index.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Gestionnaire de menu pour restaurateurs">
    <meta name="keywords" content="HTML, CSS, JavaScript">
    <meta name="author" content="Noa Cengarle, Armelle Pouzioux, Vladimir Gorbachev">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://kit.fontawesome.com/ecde10fa93.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="./style.css?v=<?php echo time(); ?>">
    <link rel="icon" href="./img/favicon.png" type="image/x-icon">
    <title>Mon profil</title>
</head>

<body>
    <?php require_once(__DIR__ . "/header.php");?>

    <!-- Si modification de profil, on affiche un message de succès -->
    <?php if (isset($_SESSION["modificationProfil"])) : ?>
        <article class="alerte alerte-succes" role="alert">
            <?php echo $_SESSION["modificationProfil"]; 
            unset($_SESSION["modificationProfil"]); ?>
        </article>
    <?php endif; ?>

    <h1>Profil de <?= htmlspecialchars($nom_utilisateur) ?></h1>

        <form method="POST" action="profil.php" class="form-connexion" class="form">
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