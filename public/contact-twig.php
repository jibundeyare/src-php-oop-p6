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

if ($_POST) {
    dump($_POST);

    $errors = [];
    $messages = [];

    if (!isset($_POST['email']) || empty($_POST['email'])) {
        $errors['email'] = true;
        $messages['email'] = "Merci de renseigner votre adresse mail";
    }

    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = true;
        $messages['email'] = "Merci de renseigner une adresse mail";
    }

    if (!isset($_POST['subject']) || empty($_POST['subject'])) {
        $errors['subject'] = true;
        $messages['subject'] = "Merci de renseigner votre le sujet";
    }

    if (!$errors) {
        sendmail('contact@example.com', $_POST['email'], $_POST['subject'], $_POST['message']);
    }
}

// affichage du rendu d'un template
echo $twig->render('contact-twig.html.twig', [
    // transmission de données au template
    'errors' => $errors,
    'messages' => $messages,
]);

