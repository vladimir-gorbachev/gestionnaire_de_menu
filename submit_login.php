<?php

session_start();
require_once(__DIR__ . "/database.php");

$postData = $_POST;

// Validation du formulaire
if (isset($postData["email"]) &&  isset($postData["mdp"])) {
    if (!filter_var($postData["email"], FILTER_VALIDATE_EMAIL)) {
        $_SESSION["LOGIN_ERROR_MESSAGE"] = "Il faut un e-mail valide pour soumettre le formulaire.";
    } 
    else {
        foreach ($utilisateurs as $utilisateur) {
            if ($utilisateur["email"] === $postData["email"] && $utilisateur["mdp"] === $postData["mdp"]){
                $_SESSION["LOGGED_USER"] = ["email" => $utilisateur["email"],
                    "utilisateur_username" => $utilisateur["utilisateur_username"]];

                // Rediriger vers la page index.php
                header("Location: index.php");
                exit();
            }
        }

        if (!isset($_SESSION["LOGGED_USER"])) {
            $_SESSION["LOGIN_ERROR_MESSAGE"] = sprintf(
                "Les informations envoyées ne permettent pas de vous identifier : (%s/%s)",
                $postData["email"],
                strip_tags($postData["mdp"]));
        }
    }
}
?>