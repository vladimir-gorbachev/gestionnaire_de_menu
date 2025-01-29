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
    }

    // Si pas d'erreur, vérifier si l'email est déjà utilisé
    if (empty($emailErr) && empty($nomErr) && empty($mot_de_passeErr)) {
        $verifEmail = $pdo->prepare("SELECT COUNT(*) FROM utilisateurs WHERE email = :email");
        $verifEmail->execute(["email" => $email]);
        if ($verifEmail->fetchColumn() > 0) {
            $emailErr = "Il y a déjà un compte avec cet email.";
        } 
        $verifNom = $pdo->prepare("SELECT COUNT(*) FROM utilisateurs 
        WHERE nom_utilisateur = :nom_utilisateur");
        $verifNom->execute(["nom_utilisateur" => $nom]);
        if ($verifNom->fetchColumn() > 0) {
            $nomErr = "Ce nom d'utilisateur est déjà pris.";
        } 
        else {
            // Cryptage du mot de passe
            $cryptMdp = password_hash($mot_de_passe, PASSWORD_DEFAULT);
        }

        // Insérer dans la base de données
        $sql = "INSERT INTO utilisateurs(nom_utilisateur, mot_de_passe, email) 
        VALUES (:nom_utilisateur, :mot_de_passe, :email)";
        $req = $pdo->prepare($sql);
        if ($req->execute([":nom_utilisateur" => $nom, ":mot_de_passe" => $cryptMdp, 
        ":email" => $email])) {
            $successMessage = "Votre compte a été créé avec succès !";
            $email = $nom = $mot_de_passe = ""; // Réinitialiser les champs
        } else {
            $emailErr = "Erreur lors de l'inscription.";
            header("Location: creation-compte.php");
            exit();
        }
    }
}
?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">

    <h2>Créez votre compte</h2>

    <p class="erreur">* champs obligatoires</p>
    
    <article class="form-connexion">
        <label for="email">Adresse e-mail:</label>
        <input type="email" id="email" name="email" placeholder="Adresse e-mail" required 
        value="<?php echo $email;?>">
        <p class="erreur">* <?php echo $emailErr;?></p>
    </article>

    <article class="form-connexion">
        <label for="nom">Nom d'utilisateur:</label>
        <input type="text" id="nom" name="nom" placeholder="Nom d'utilisateur" required 
        value="<?php echo $nom;?>">
        <p class="erreur">* <?php echo $nomErr;?></p>
    </article>

    <article class="form-connexion">
        <label for="mot_de_passe">Mot de passe:</label>
        <input type="password" id="mot_de_passe" name="mot_de_passe" placeholder="Mot de passe" required 
        value="<?php echo $mot_de_passe;?>">
        <p class="erreur">* <?php echo $mot_de_passeErr;?></p>
    </article>

    <!-- <article class="form-connexion">
        <label for="confirmer-mdp">Confirmer mot de passe:</label>
        <input type="password" id="confirmer-mdp" name="confirmer-mdp" 
        placeholder="Confirmer mot de passe">
    </article> -->

    <input type="submit" value="Créer le compte">

</form>