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

if ($_POST) {
    dump($_POST);

    $errors = [];
    $messages = [];

    // remplacement des valeur par défaut par celles de l'utilisateur
    if (isset($_POST['email'])) {
        $formData['email'] = $_POST['email'];
    }

    if (isset($_POST['subject'])) {
        $formData['subject'] = $_POST['subject'];
    }

    // @todo ajouter le bloc pour le champ message

    // validation des données envoyées par l'utiilisateur
    if (!isset($_POST['email']) || empty($_POST['email'])) {
        $errors['email'] = true;
        $messages['email'] = "Merci de renseigner votre adresse mail";
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = true;
        $messages['email'] = "Merci de renseigner une adresse mail valide";
    }

    // @todo compléter la validation :
    // - s'assurer que le sujet fait plus de 3 caractères et moins de 201 caractères
    if (!isset($_POST['subject']) || empty($_POST['subject'])) {
        $errors['subject'] = true;
        $messages['subject'] = "Merci de renseigner votre le sujet";
    }

    // @todo compléter la validation pour le champ message :
    // - s'assurer que le message ne contient pas de caractères <, ou >
    // - s'assurer que le message fait plus de 3 caractères et moins de 1001 caractères

    if (!$errors) {
        sendmail('contact@example.com', $_POST['email'], $_POST['subject'], $_POST['message']);
    }
}

// affichage du rendu d'un template
echo $twig->render('contact-twig.html.twig', [
    // transmission de données au template
    'errors' => $errors,
    'messages' => $messages,
    'formData' => $formData,
]);

