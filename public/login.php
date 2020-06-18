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

// chargement des données de l'utilisateur
$user = require __DIR__.'/user-data.php';

// valeurs par défaut du formulaire
$formData = [
    'login' => '',
    'password' => '',
];

// le tableau contenant la liste des erreurs
$errors = [];
// le tableau contenant les messages d'erreur
$messages = [];

// vérification de présence de données envoyées par l'utilisateur
if ($_POST) {
    // remplacement des valeurs par défaut par les valeurs envoyées par l'utilisateur
    if (isset($_POST['login'])) {
        $formData['login'] = $_POST['login'];
    }

    // validation des données du champ login
    if (!isset($_POST['login']) || empty($_POST['login'])) {
        $errors['form'] = true;
        $messages['form'] = 'identifiant ou mot de passe incorrect';
    } elseif (strlen($_POST['login']) < 4 || strlen($_POST['login']) > 100) {
        $errors['form'] = true;
        $messages['form'] = 'identifiant ou mot de passe incorrect';
    } elseif ($_POST['login'] != $user['login']) {
        $errors['form'] = true;
        $messages['form'] = 'identifiant ou mot de passe incorrect';
    }

    // validation des données du champ password
    if (!isset($_POST['password']) || empty($_POST['password'])) {
        $errors['form'] = true;
        $messages['form'] = 'identifiant ou mot de passe incorrect';
    } elseif (strlen($_POST['password']) < 4 || strlen($_POST['password']) > 100) {
        $errors['form'] = true;
        $messages['form'] = 'identifiant ou mot de passe incorrect';
    } elseif (!password_verify($_POST['password'], $user['password_hash'])) {
        $errors['form'] = true;
        $messages['form'] = 'identifiant ou mot de passe incorrect';
    }

    // on vérifie s'il y a des erreurs
    if (!$errors) {
        // il n'y a pas d'erreurs

        // démarrage de la session
        session_start();

        // enregistrement de données dans la variable de session
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['login'] = $user['login'];

        // redirection de l'utilisateur vers la page privée
        $url = 'private-page.php';
        header("Location: {$url}", true, 302);
        exit();
    }
}

// affichage du rendu d'un template
echo $twig->render('login.html.twig', [
    // transmission de données au template
    'formData' => $formData,
    'errors' => $errors,
    'messages' => $messages,
]);

