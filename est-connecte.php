<?php

if (!isset($_SESSION["LOGGED_USER"])) {
    header("Location: connexion.php");
    exit;
}