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

$formData = [
    'email' => '',
    'subject'  => '',
    'message' => '',
];

$errors = [];
$messages = [];

if ($_POST) {
    // remplacement des valeur par défaut par celles de l'utilisateur
    if (isset($_POST['email'])) {
        $formData['email'] = $_POST['email'];
    }

    if (isset($_POST['subject'])) {
        $formData['subject'] = $_POST['subject'];
    }

    if (isset($_POST['message'])) {
        $formData['message'] = $_POST['message'];
    }

    // validation des données envoyées par l'utiilisateur
    if (!isset($_POST['email']) || empty($_POST['email'])) {
        $errors['email'] = true;
        $messages['email'] = "Merci de renseigner votre adresse mail";
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = true;
        $messages['email'] = "Merci de renseigner une adresse mail valide";
    }

    if (!isset($_POST['subject']) || empty($_POST['subject'])) {
        $errors['subject'] = true;
        $messages['subject'] = "Merci de renseigner le sujet";
    } elseif (strlen($_POST['subject']) < 4) {
        $errors['subject'] = true;
        $messages['subject'] = "Le sujet doit faire 4 caractères minimum";
    } elseif (strlen($_POST['subject']) > 200) {
        $errors['subject'] = true;
        $messages['subject'] = "Le sujet doit faire 200 caractères maximum";
    }

    if (!isset($_POST['message']) || empty($_POST['message'])) {
        $errors['message'] = true;
        $messages['message'] = "Merci de renseigner votre message";
    } elseif (strlen($_POST['message']) < 4) {
        $errors['message'] = true;
        $messages['message'] = "Le message doit faire 4 caractères minimum";
    } elseif (strlen($_POST['message']) > 1000) {
        $errors['message'] = true;
        $messages['message'] = "Le message doit faire 1000 caractères maximum";
    } elseif (
        strpos($_POST['message'], '<') !== false
        || strpos($_POST['message'], '>') !== false
    ) {
        $errors['message'] = true;
        $messages['message'] = "Les caractères suivants sont interdits : < >";
    }

    if (!$errors) {
        dump('ok');
    }
}

// affichage du rendu d'un template
echo $twig->render('contact-twig.html.twig', [
    // transmission de données au template
    'errors' => $errors,
    'messages' => $messages,
    'formData' => $formData,
]);

