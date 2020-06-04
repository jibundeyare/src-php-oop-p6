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

$displayDoc = false;
$doc = 'Lorem ipsum...';
$data = [];
$data['foo'] = 'bar';

// affichage du rendu d'un template
echo $twig->render('test-twig.html.twig', [
    'displayDoc' => $displayDoc,
    'doc' => $doc,
    'data' => $data,
]);
