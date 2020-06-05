<?php

// activation du système d'autoloading de Composer
require __DIR__.'/../vendor/autoload.php';

// instanciation du chargeur de templates
$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../templates');

// instanciation du moteur de template
$twig = new \Twig\Environment($loader, [
    // activation du mode debug
    'debug' => true,
    // activation du mode de variables strictes
    'strict_variables' => true,
]);

// chargement de l'extension Twig_Extension_Debug
$twig->addExtension(new \Twig\Extension\DebugExtension());

// démarrage de la session
session_start();

// écriture de données dans la variable de session
$_SESSION['foo'] = 'bar';

// simulation du chargement des données de la base de données
$user = require __DIR__.'/user-data.php';

// liste des champs pour lesquels une erreur est signalée
$errors = [];

if (!$errors) {
    // s'il n'y a aucune erreur, on peut affecter des données à la variable de session
    $_SESSION['login'] = $user['login'];
    $_SESSION['user_id'] = $user['user_id'];
}

// affichage du rendu d'un template
echo $twig->render('session-write-twig.html.twig', [
]);

