<?php
session_start();
require_once(__DIR__ . "/base-donnees.php");
require_once(__DIR__ . "/est-connecte.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $plat_id = $_POST["plat_id"] ?? null;

    if ($plat_id !== null) {
        $sql = "DELETE FROM plats WHERE id = :plat_id";
        $req = $pdo->prepare($sql);

        if ($req->execute([":plat_id" => $plat_id])) {
            $_SESSION["suppressionRecette"] = "Votre recette a bien été supprimée !";
            header("Location: index.php"); // Redirection après suppression
            exit();
        } else {
            $_SESSION["suppressionRecette"] = "Erreur lors de la suppression.";
        }
    }
}
?>