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

// on vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // l'utilisateur n'est pas connecté

    // redirection de l'utilisateur vers la page de login
    $url = 'login.php';
    header("Location: {$url}", true, 302);
    exit();
}

// affichage du rendu d'un template
echo $twig->render('private-page.html.twig', [
    // transmission de données au template
    'session' => $_SESSION,
]);

