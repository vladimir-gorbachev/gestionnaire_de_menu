<?php
session_start();
require_once(__DIR__ . "/base-donnees.php");
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
    <title>Découvrez nos recettes</title>
</head>

    <body>       
        <?php require_once(__DIR__ . "/header.php");

        // Récupérer les informations des plats
        $query = "SELECT plats.id, plats.nom, plats.categorie_id, plats.prix, plats.description, 
        plats.image, plats.utilisateur_id, categories.nom AS categorie_nom FROM plats 
        INNER JOIN categories ON plats.categorie_id = categories.id";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $plats = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

    <section class="recettes">
        <?php if (!empty($plats)): ?>
            <?php foreach ($plats as $plat): ?>
                <article class="recette">
                    <h1><?= htmlspecialchars($plat['nom']) ?></h1>

                    <p class="categorie"><?= htmlspecialchars($plat['categorie_nom']) ?></p>

                    <p><?= htmlspecialchars($plat['prix']) ?> €</p>

                    <img src="<?= htmlspecialchars($plat['image']) ?>" 
                    alt="image de : <?= htmlspecialchars($plat['nom']) ?>">

                    <p><?= htmlspecialchars($plat['description']) ?></p>

                    <?php if (isset($_SESSION["utilisateur-connecte"]) && 
                    isset($_SESSION["utilisateur-connecte"]["id"]) && 
                    $_SESSION["utilisateur-connecte"]["id"] == $plat["utilisateur_id"]) : ?>

                        <form action="./modifier-recette.php" method="GET">
                            <input type="hidden" id="plat_id" name="plat_id" value="<?php echo $plat["id"] ?>">
                            <input type="submit" value="Modifier ma recette" class="form-get">
                        </form>
                    <?php endif; ?>

                </article>
            <?php endforeach; ?>
                
        <?php else: ?>
            <p>Aucun plat disponible pour le moment.</p>
        <?php endif; ?>
    </section>

        <?php include 'footer.php'; ?>
    </body>
</html>