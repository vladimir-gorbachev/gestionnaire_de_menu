<?php
session_start();
require_once(__DIR__ . "/base-donnees.php");

// Vérification du formulaire soumis
$email = $mot_de_passe = "";
$emailErr = $mot_de_passeErr = $loginErr = "";

function test_saisie($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["email"])) {
        $emailErr = "L'email est requis.";
    }
    else {
        $email = test_saisie($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "L'adresse email n'est pas écrite dans un format valide.";
          }
    }
    if (empty($_POST["mot_de_passe"])) {
        $mot_de_passeErr = "Le mot de passe est requis.";
    }
    else {
        $mot_de_passe = test_saisie($_POST["mot_de_passe"]);
    }

    if (empty($emailErr) && empty($mot_de_passeErr)) {
        $sql = "SELECT * FROM utilisateurs WHERE email = :email";
        $req = $pdo->prepare($sql);
        $req->execute(["email" => $email]);
        $utilisateur = $req->fetch(PDO::FETCH_ASSOC);

        if ($utilisateur && password_verify($mot_de_passe, $utilisateur["mot_de_passe"])) {
            // Stocker l'utilisateur en session
            $_SESSION["utilisateur-connecte"] = [
                "id" => $utilisateur["id"],
                "nom_utilisateur" => $utilisateur["nom_utilisateur"],
                "email" => $utilisateur["email"]];
            header("Location: index.php");
            exit();
        } 
        else {
            $loginErr = "Email ou mot de passe incorrect";
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
    <title>Plat'form</title>
</head>
<body>
    <!-- inclusion de l'entête du site -->
    <?php require_once(__DIR__ . "/header.php"); ?>

    <?php if (!isset($_SESSION["utilisateur-connecte"])) : ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">

            <p class="erreur"><?php echo $loginErr; ?></p>

            <?php if (!empty($succesMessage)) : ?>
                <p class="succes"><?php echo $succesMessage; ?></p>
            <?php endif; ?>

            <h2>Connexion à votre compte</h2>
            
            <article class="form-connexion">
                <label for="email">Adresse e-mail:</label>
                <input type="email" id="email" name="email" placeholder="Adresse e-mail" required 
                value="<?php echo htmlspecialchars($email);?>">
            </article>

            <article class="form-connexion">
                <label for="mot_de_passe">Mot de passe:</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" placeholder="Mot de passe" 
                required>
            </article>

            <input type="submit" value="Se connecter">
            <!-- <a href="#">Mot de passe oublié ?</a> -->

            <a href="./creation-compte.php">Pas encore de compte ? C'est par ici !</a>

        </form>

    <?php endif; ?>

    <!-- inclusion du bas de page du site -->
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