<?php
session_start();
require_once(__DIR__ . "/base-donnees.php");

// Vérification du formulaire soumis
$email = $nom = $mot_de_passe = "";
$emailErr = $nomErr = $mot_de_passeErr = "";

function test_saisie($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["email"])) {
        $emailErr = "Un email est nécessaire pour la création du compte.";
    }
    else {
        $email = test_saisie($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "L'adresse email n'est pas écrite dans un format valide.";
          }
    }
    if (empty($_POST["nom"])) {
        $nomErr = "Un nom d'utilisateur est nécessaire pour la création du compte.";
    }
    else {
        $nom = test_saisie($_POST["nom"]);
    }
    if (empty($_POST["mot_de_passe"])) {
        $mot_de_passeErr = "Un mot de passe est nécessaire pour la création du compte.";
    }
    else {
        $mot_de_passe = test_saisie($_POST["mot_de_passe"]);
        if (strlen($mot_de_passe) < 8 || !preg_match("/[A-Za-z]/", $mot_de_passe) || !preg_match("/[0-9]/", $mot_de_passe)) {
            $mot_de_passeErr = "Le mot de passe doit contenir au moins 8 caractères, dont une lettre et un chiffre.";
        }
    }
    if (empty($_POST["confirmer_mdp"])) {
        $confirmer_mdpErr = "Veuillez confirmer votre mot de passe.";
    } 
    else {
        $confirmer_mdp = test_saisie($_POST["confirmer_mdp"]);
        if ($mot_de_passe !== $confirmer_mdp) {
            $confirmer_mdpErr = "Les mots de passe ne correspondent pas.";
        }
    }

    // Vérifier si l'email OU le nom d'utilisateur existent déjà
    if (empty($emailErr) && empty($nomErr) && empty($mot_de_passeErr) && empty($confirmer_mdpErr)) {
        $verif = $pdo->prepare("SELECT email, nom_utilisateur FROM utilisateurs 
        WHERE email = :email OR nom_utilisateur = :nom");
        $verif->execute(["email" => $email, "nom" => $nom]);
        $result = $verif->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            if ($result["email"] == $email) {
                $emailErr = "Un compte existe déjà avec cet email.";
            }
            if ($result["nom_utilisateur"] == $nom) {
                $nomErr = "Ce nom d'utilisateur est déjà pris.";
            }
        } 
        else {
            // Cryptage du mot de passe
            $cryptMdp = password_hash($mot_de_passe, PASSWORD_DEFAULT);

            // Insérer dans la base de données
            $sql = "INSERT INTO utilisateurs(nom_utilisateur, mot_de_passe, email) 
                    VALUES (:nom_utilisateur, :mot_de_passe, :email)";
            $req = $pdo->prepare($sql);
            if ($req->execute([":nom_utilisateur" => $nom, ":mot_de_passe" => $cryptMdp, 
            ":email" => $email])) {
                $_SESSION["succesMessage"] = "Votre compte a été créé avec succès !";
                $email = $nom = $mot_de_passe = ""; // Réinitialiser les champs
                header("Location: connexion.php");
                exit();
                die();
            } 
            else {
                $emailErr = "Erreur lors de l'inscription.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">

    <title>Plat'form</title>
</head>
<body>
    <?php require_once(__DIR__ . "/header.php"); ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">

        <h2>Créez votre compte</h2>
        
        <article class="form-connexion">
            <label for="email">Adresse e-mail:</label>
            <input type="email" id="email" name="email" placeholder="Adresse e-mail" required 
            value="<?php echo htmlspecialchars($email);?>">

            <?php if (!empty($emailErr)) : ?>
                <p class="erreur"><?php echo $emailErr; ?></p>
            <?php endif; ?>
        </article>

        <article class="form-connexion">
            <label for="nom">Nom d'utilisateur:</label>
            <input type="text" id="nom" name="nom" placeholder="Nom d'utilisateur" required 
            value="<?php echo htmlspecialchars($nom);?>">

            <?php if (!empty($nomErr)) : ?>
                <p class="erreur"><?php echo $nomErr;?></p>
            <?php endif; ?>
        </article>

        <article class="form-connexion">
            <label for="mot_de_passe">Mot de passe:</label>
            <input type="password" id="mot_de_passe" name="mot_de_passe" placeholder="Mot de passe" 
            required>
            
            <?php if (!empty($mot_de_passeErr)) : ?>
                <p class="erreur"><?php echo $mot_de_passeErr;?></p>
            <?php endif; ?>
        </article>

        <article class="form-connexion">
            <label for="confirmer_mdp">Confirmer le mot de passe:</label>
            <input type="password" id="confirmer_mdp" name="confirmer_mdp" 
            placeholder="Confirmer le mot de passe" required>

            <?php if (!empty($confirmer_mdpErr)) : ?>
                <p class="erreur"><?php echo $confirmer_mdpErr; ?></p>
            <?php endif; ?>
        </article>

        <input type="submit" value="Créer le compte">

    </form>

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