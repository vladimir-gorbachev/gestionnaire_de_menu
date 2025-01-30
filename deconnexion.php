<?php
session_start();

// Temps maximal d'inactivité (10 minutes)
$inactivity_limit = 600;

if (isset($_SESSION["LAST_ACTIVITY"])) {
    if (time() - $_SESSION["LAST_ACTIVITY"] > $inactivity_limit) {
        session_unset();
        session_destroy();
    }
}

session_unset();
session_destroy();
header("Location: index.php");
exit();