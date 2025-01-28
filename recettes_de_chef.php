<?php
// config.php : Configuration pour se connecter à la base de données
$host = 'localhost'; // Adresse du serveur (ou localhost si local)
$dbname = 'gestionnaire_de_menu'; // Nom de la base de données
$username = 'root'; // Nom d'utilisateur
$password = ''; // Mot de passe

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (exception $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>


<?php

try {
    // Requête pour récupérer tous les plats partagés
    $query = $pdo->query("SELECT * FROM plats_partagés");

    // Récupération des données sous forme de tableau associatif
    $platsPartages = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (exception $e) {
    die("Erreur lors de la récupération des données : " . $e->getMessage());
}
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'Accueil</title>
    <link rel="stylesheet" href="recettes_de_chef.css">
</head>
<body>

    <div class="onglets">
        <?php foreach ($platsPartages as $plat): ?>
            <div class="onglet">
                <h2 class="title">
                    <?php htmlspecialchars($plat['nom']); ?><br>
                    <?php htmlspecialchars($plat['categorie']); ?><br>
                    <?php htmlspecialchars(number_format($plat['prix'], 2)); ?>€/personne
                </h2>
                <figure>
                    <ul class="ingredients">
                        <?php
                        // Convertir la liste des ingrédients (séparés par des virgules) en tableau
                        $ingredients = explode(',', $plat['ingredients']);
                        foreach ($ingredients as $ingredient):
                        ?>
                            <li><?= htmlspecialchars(trim($ingredient)); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <img src="<?= htmlspecialchars($plat['image']); ?>" alt="Photo de <?= htmlspecialchars($plat['nom']); ?>" class="photo">
                    <figcaption class="description">
                        <?= htmlspecialchars($plat['description']); ?>
                    </figcaption>
                </figure>
            </div>
        <?php endforeach; ?>
            
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
</html>
