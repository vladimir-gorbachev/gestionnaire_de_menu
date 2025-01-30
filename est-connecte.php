<?php

if (!isset($_SESSION["utilisateur-connecte"])) {
    header("Location: connexion.php");
    exit;
}