<?php
session_start();
require_once(__DIR__ . "/base-donnees.php")
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Page d'Accueil</title>
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="recettes_de_chef.css">
    </head>

    <body>       
        <!-- inclusion de l'entête du site -->
        <?php require_once(__DIR__ . "/header.php");

       // Récupérer les informations des plats
        $query = "SELECT plats.id, plats.nom, categorie_id, prix, description, image, utilisateur_id FROM plats 
        INNER JOIN categories WHERE plats.categorie_id = categories.id";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $plats = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <?php if (!empty($plats)): ?>
            <div class="onglets">
                <?php foreach ($plats as $plat): ?>
                    <div class="onglet">
                        <h2><?= htmlspecialchars($plat['nom']) ?></h2>
                        <p><?= htmlspecialchars($plat['categorie_id']) ?></p>
                        <p><?= htmlspecialchars($plat['prix']) ?> €</p>
                        <img src="<?= htmlspecialchars($plat['image']) ?>" alt="image de : <?= htmlspecialchars($plat['nom']) ?>">
                        <p><?= htmlspecialchars($plat['description']) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Aucun plat disponible pour le moment.</p>
        <?php endif; ?>

        <?php include 'footer.php'; ?>
    </body>
</html>