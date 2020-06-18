<?php

// démarrage de la session
session_start();
// suppression de toutes les données de la session
session_unset();
// suppression de la session
session_destroy();

// redirection de l'utilisateur vers la page de login
$url = 'login.php';
header("Location: {$url}", true, 302);
exit();
