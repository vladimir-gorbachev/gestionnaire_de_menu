<?php 
try {
    $pdo = new PDO("mysql:host=localhost;dbname=gestionnaire_de_menu;charset=utf8", "utilisateur", "utilisateur123");
    $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (exception $e) {
    die("Erreur: ".$e->getMessage());
}
?>