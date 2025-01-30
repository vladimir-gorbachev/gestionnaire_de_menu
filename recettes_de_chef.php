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

        // Connexion à la base de données
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=gestionnaire_de_menu', 'root', '');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }

       // Récupérer les plats avec leurs ingrédients
        $query = "
        SELECT 
            plats.id, 
            plats.nom AS nom, 
            plats.categorie_id, 
            categories.nom AS categorie_nom,  -- Nom de la catégorie
            plats.prix, 
            plats.image, 
            plats.description, 
            GROUP_CONCAT(ingredients.nom_ingredient SEPARATOR ', ') AS liste_des_ingredients
        FROM plats
        -- Jointure avec la table `categories` pour récupérer le nom de la catégorie
        LEFT JOIN categories ON plats.categorie_id = categories.id
        LEFT JOIN plats_ingredients ON plats.id = plats_ingredients.plat_id
        LEFT JOIN ingredients ON plats_ingredients.ingredient_id = ingredients.id
        GROUP BY plats.id";
        
        $stmt = $pdo->query($query);
        $plats = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <?php 
        if (count($plats) > 0): ?>
            <div class="onglets">
                <?php foreach ($plats as $plat): ?>
                    <div class="onglet">
                        <h2><?= htmlspecialchars($plat['nom']) ?></h2>
                        <p><?= htmlspecialchars($plat['categorie_id']) ?></p>
                        <p><?= htmlspecialchars($plat['prix']) ?> €</p>
                        <!-- <figure>
                            <figcaption><strong>Ingrédients :</strong> <?= htmlspecialchars($plat['ingredients'] ?? 'Aucun ingrédient') ?></figcaption>
                        </figure> -->
                        <img src="<?= htmlspecialchars($plat['image']) ?>" alt="image de : <?= htmlspecialchars($plat['nom']) ?>">
                        <p><?= htmlspecialchars($plat['description']) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Aucun plat disponible pour le moment.</p>
        <?php endif; ?>

        <div class="onglets">
                
                <div class="onglet">
                    <h2 class="title">Salade César <br> Entrée <br> 4€/personne </h2>
                    <figure>
                        <ul class="ingredients">
                            <li>Laitue Romaine</li>
                            <li>Poulet Grillé</li>
                            <li>Parmesan</li>
                            <li>Croûtons</li>
                            <li>Sauce César</li>
                            <li>Oeuf mollet</li>
                            <li>Bacon</li>
                        </ul>
                        <img src="img/salade_cesar.png" alt="Photo de la Salade César" class="photo">
                        <figcaption class="description">
                            Salade classique et savoureuse, composée de laitue romaine croquante, de poulet grillé, de copeaux de parmesan, de croûtons dorés, et relevée par une sauce crémeuse à base de mayonnaise, d'ail, de parmesan et d'anchois. Ce plat, à la fois léger et gourmand, est idéal en entrée ou en plat principal.
                        </figcaption>
                    </figure>
                </div>
                <div class="onglet">
                    <h2 class="title">Gnocchi épinards gorgonzola <br>Plat <br> 7€/personne</h2>
                    <figure>
                        <ul class="ingredients">
                            <li>Gnocchis</li>
                            <li>Epinards frais</li>
                            <li>Gorgonzola</li>
                            <li>Crème fraiche liquide</li>
                            <li>Ail</li>
                            <li>Beurre</li>
                            <li>Sel et Poivre</li>
                        </ul>
                        <img src="img/gnocchis_epinards.png" alt="Photo des gnocchis aux épinards" class="photo">
                        <figcaption class="description">
                        Plat italien crémeux et réconfortant. Les gnocchis moelleux sont enrobés d'une sauce onctueuse au gorgonzola, sublimée par la douceur des épinards et une touche de muscade. Un mélange parfait de saveurs et de textures pour un repas gourmand.
                        </figcaption>
                    </figure>
                </div>
                <div class="onglet">
                    <h2 class="title">Pastel de Nata <br> Dessert<br> 2€/personne </h2>
                    <figure>
                        <ul class="ingredients">
                            <li>Pate feuilletée</li>
                            <li>Lait entier</li>
                            <li>Crème liquide</li>
                            <li>Farine</li>
                            <li>Sucre</li>
                            <li>Jaunes d'oeufs</li>
                            <li>Zeste de citron</li>
                        </ul>
                        <img src="img/pastel_de_nata.png" alt="Photo des pastel de nata" class="photo">
                        <figcaption class="description">
                        Petites tartes portugaises à la crème, au cœur fondant et parfumé à la cannelle et au citron, nichées dans une pâte feuilletée croustillante. Un délice emblématique du Portugal, souvent dégusté tiède avec une touche de sucre glace ou de cannelle.
                        </figcaption>
                    </figure>
                </div>
                    
            </div>
            <?php include 'footer.php'; ?>
    </body>
</html>




<!-- 
        

        <div class="onglets">
                
            <div class="onglet">
                <h2 class="title">Salade César <br> Entrée <br> 4€/personne </h2>
                <figure>
                    <ul class="ingredients">
                        <li>Laitue Romaine</li>
                        <li>Poulet Grillé</li>
                        <li>Parmesan</li>
                        <li>Croûtons</li>
                        <li>Sauce César</li>
                        <li>Oeuf mollet</li>
                        <li>Bacon</li>
                    </ul>
                    <img src="img/salade_cesar.png" alt="Photo de la Salade César" class="photo">
                    <figcaption class="description">
                        Salade classique et savoureuse, composée de laitue romaine croquante, de poulet grillé, de copeaux de parmesan, de croûtons dorés, et relevée par une sauce crémeuse à base de mayonnaise, d'ail, de parmesan et d'anchois. Ce plat, à la fois léger et gourmand, est idéal en entrée ou en plat principal.
                    </figcaption>
                </figure>
            </div>
            <div class="onglet">
                <h2 class="title">Gnocchi épinards gorgonzola <br>Plat <br> 7€/personne</h2>
                <figure>
                    <ul class="ingredients">
                        <li>Gnocchis</li>
                        <li>Epinards frais</li>
                        <li>Gorgonzola</li>
                        <li>Crème fraiche liquide</li>
                        <li>Ail</li>
                        <li>Beurre</li>
                        <li>Sel et Poivre</li>
                    </ul>
                    <img src="img/gnocchis_epinards.png" alt="Photo des gnocchis aux épinards" class="photo">
                    <figcaption class="description">
                    Plat italien crémeux et réconfortant. Les gnocchis moelleux sont enrobés d'une sauce onctueuse au gorgonzola, sublimée par la douceur des épinards et une touche de muscade. Un mélange parfait de saveurs et de textures pour un repas gourmand.
                    </figcaption>
                </figure>
            </div>
            <div class="onglet">
                <h2 class="title">Pastel de Nata <br> Dessert<br> 2€/personne </h2>
                <figure>
                    <ul class="ingredients">
                        <li>Pate feuilletée</li>
                        <li>Lait entier</li>
                        <li>Crème liquide</li>
                        <li>Farine</li>
                        <li>Sucre</li>
                        <li>Jaunes d'oeufs</li>
                        <li>Zeste de citron</li>
                    </ul>
                    <img src="img/pastel_de_nata.png" alt="Photo des pastel de nata" class="photo">
                    <figcaption class="description">
                    Petites tartes portugaises à la crème, au cœur fondant et parfumé à la cannelle et au citron, nichées dans une pâte feuilletée croustillante. Un délice emblématique du Portugal, souvent dégusté tiède avec une touche de sucre glace ou de cannelle.
                    </figcaption>
                </figure>
            </div>
                
        </div>
    </body>
</html> -->
