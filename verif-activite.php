<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Temps maximal d'inactivité (10 minutes)
$limiteInactivite = 600;

if (isset($_SESSION["derniereActivite"])) {
    if (time() - $_SESSION["derniereActivite"] > $limiteInactivite) {
        session_unset();
        session_destroy();
        header("Location: index.php");
        exit();
    }
}

// Mettre à jour le timestamp de l'activité
$_SESSION["derniereActivite"] = time();

?>