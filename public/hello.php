<?php

// activation du système d'autoloading de Composer
require __DIR__.'/../vendor/autoload.php';

// instanciation du chargeur de templates
$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../templates');

// instanciation du moteur de template
$twig = new \Twig\Environment($loader);

// initialisation d'une donnée
$greeting = 'Hello Twig!';

// affichage du rendu d'un template
echo $twig->render('hello-twig.html.twig', [
    // transmission de données au template
    'greeting' => $greeting,
]);
