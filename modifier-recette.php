<?php
session_start();
require_once(__DIR__ . "/base-donnees.php");
require_once(__DIR__ . "/est-connecte.php");

$plat_id = isset($_GET["plat_id"]) ? $_GET["plat_id"] : null;
if ($plat_id === null) {
    die("Erreur : plat_id manquant.");
}

$sql = "SELECT * FROM plats WHERE plats.id = $plat_id";
$req = $pdo->prepare($sql);
$req->execute();
$plat = $req->fetch(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST["nom"];
    $categorie_id = $_POST["categorie"];
    $prix = $_POST["prix"];
    $description = $_POST["description"];

    // Création de la requête de mise à jour dynamique
    $updateFields = [];
    $params = [];

    if (!empty($nom)) {
        $updateFields[] = "nom = :nom";
        $params[':nom'] = $nom;
    }

    if (!empty($categorie_id)) {
        $updateFields[] = "categorie_id = :categorie_id";
        $params[':categorie_id'] = $categorie_id;
    }

    if (!empty($prix)) {
        $updateFields[] = "prix = :prix";
        $params[':prix'] = $prix;
    }

    if (!empty($description)) {
        $updateFields[] = "description = :description";
        $params[':description'] = $description;
    }

    if (!empty($updateFields)) {
        // Construire la requête SQL avec les champs modifiés
        $sql = "UPDATE plats SET " . implode(", ", $updateFields) . " WHERE id = :plat_id";
        $params[':plat_id'] = $plat_id;

        $req = $pdo->prepare($sql);
        
        // Exécuter la requête
        if ($req->execute($params)) {
            $_SESSION["modificationRecette"] = "Votre recette a bien été modifiée !";

            // Récupérer à nouveau les données du plat après la mise à jour
            $req = $pdo->prepare("SELECT * FROM plats WHERE plats.id = :plat_id");
            $req->execute([':plat_id' => $plat_id]);
            $plat = $req->fetch(PDO::FETCH_ASSOC);
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="./style.css?v=<?php echo time(); ?>">
    <link rel="icon" href="./img/favicon.ico" type="image/x-icon">
    <title>Modifiez votre recette</title>
</head>
<body>
    <?php require_once(__DIR__ . "/header.php"); ?>

    <!-- Si modification de recette, on affiche un message de succès -->
    <?php if (isset($_SESSION["modificationRecette"])) : ?>
        <article class="alerte alerte-succes" role="alert">
            <?php echo $_SESSION["modificationRecette"]; 
            unset($_SESSION["modificationRecette"]); // Réinitialisation du message ?>
        </article>
    <?php endif; ?>

    <form action="modifier-recette.php?plat_id=<?php echo $plat_id ?>" method="POST" 
    enctype="multipart/form-data">


        <h2>Modifiez votre recette</h2>

        <article class="form-connexion">
            <label for="nom">Nom de la recette:</label>
            <input type="text" id="nom" name="nom" placeholder="<?php echo $plat["nom"] ?>" 
            value="<?php echo htmlspecialchars($plat["nom"]); ?>">
        </article>

        <article class="form-connexion">
            <?php if ($plat["categorie_id"] == 4) : ?>
                <input type="radio" id="entree" name="categorie" value="4" 
                <?php echo ($plat["categorie_id"] == 4) ? 'checked' : ''; ?>>
                <label for="entree">Entrée</label>
                <input type="radio" id="plat" name="categorie" value="5">
                <label for="plat">Plat principal</label>
                <input type="radio" id="dessert" name="categorie" value="6">
                <label for="dessert">Dessert</label>
            <?php endif ; ?>
            <?php if ($plat["categorie_id"] == 5) : ?>
                <input type="radio" id="entree" name="categorie" value="4">
                <label for="entree">Entrée</label>
                <input type="radio" id="plat" name="categorie" value="5" 
                <?php echo ($plat["categorie_id"] == 5) ? 'checked' : ''; ?>>
                <label for="plat">Plat principal</label>
                <input type="radio" id="dessert" name="categorie" value="6">
                <label for="dessert">Dessert</label>
            <?php endif ; ?>
            <?php if ($plat["categorie_id"] == 6) : ?>
                <input type="radio" id="entree" name="categorie" value="4">
                <label for="entree">Entrée</label>
                <input type="radio" id="plat" name="categorie" value="5">
                <label for="plat">Plat principal</label>
                <input type="radio" id="dessert" name="categorie" value="6" 
                <?php echo ($plat["categorie_id"] == 6) ? 'checked' : ''; ?>>
                <label for="dessert">Dessert</label>
            <?php endif ; ?>
        </article>

        <article class="form-connexion">
            <label for="prix">Prix en €:</label>
            <input type="number" id="prix" name="prix" min="0" placeholder="<?php echo $plat["prix"] ?>" 
            value="<?php echo htmlspecialchars($plat["prix"]); ?>">
        </article>

        <article class="form-connexion">
            <label for="description">Description:</label>
            <textarea id="description" name="description" 
            placeholder="<?php echo $plat["description"] ?>"><?php 
            echo htmlspecialchars($plat["description"]); ?></textarea>
        </article>

        <article class="form-connexion">
            <label for="photo">Photo:</label>
            <input type="file" id="photo" name="photo" accept=".jpg, .jpeg, .png, .webp, .svg">
        </article>

        <input type="hidden" id="utilisateur_id" name="utilisateur_id" 
        value="<?php echo $_SESSION["utilisateur-connecte"]["id"] ?>">

        <input type="hidden" id="plat_id" name="plat_id" value="<?php echo $plat_id ?>">

        <input type="submit" value="Modifier ma recette">

    </form>

    <form action="supprimer-recette.php" method="POST">
        <input type="hidden" name="plat_id" value="<?php echo $plat_id; ?>">
        <input type="submit" value="Supprimer ma recette" 
        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette recette ?');">
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