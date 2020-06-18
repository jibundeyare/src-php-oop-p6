# Exo login

## Objectif

Mettre en place un système d'identification par mot de passe et pouvoir protéger des pages privées.

## Mission

Vous devrez créer plusieurs scripts PHP et templates Twig :

- la page de login `public/login.php` et son template `templates/login.html.twig`
- la page privées `public/private-page.php` et son template `templates/private-page.html.twig`
- la page de déconnexion `public/logout.php` (qui n'a pas besoin de template)

Vous êtes libre d'utiliser bootstrap ou un autre framework CSS mais dans tout les cas vous devez soigner l'apparence.
Les templates Twig en HTML brut sans aucune feuille de style sont refusés.

### Le compte utilisateur

La connexion ne doit fonctionner que si vous avez entré les données suivante dans le formulaire de login :

1. `login` : `toto`
2. `password` : `12345678`

### La page de login

La page de login doit afficher un formulaire HTML avec deux champs :

1. `login` : champ input de type text
2. `password` : champ input de type password

Les données du formulaire  doivent être envoyée avec la méthode `post`.

La page de login doit traiter les données du formulaire renvoyées par l'utilisateur :

1. vérifier si la variable `$_POST` est vide
2. valider les données du formulaire (`login` et `password`)
3. s'il y a une erreur de `login` ou de `password`, afficher le même message d'erreur `"identifiant ou mot de passe incorrect"`
4. s'il n'y a pas d'erreurs, écrire le `user_id` et le `login` de l'utilisateur dans la variable de session puis rediriger l'utilisateur vers la page privée.

#### La base de données des utilisateurs

Nous n'avons pas encore vu l'utilisation des bases de données.
Donc, au lieu de requêter la base de données, nous allons *faire comme si*.

Pour récupérer les données de l'utilisateur, vous pouvez utiliser le code suivant :

    $user = require __DIR__.'/user-data.php';

**Attention** : copiez le fichier `public/user-data.php` dans le  dossier `public` votre de projet, sinon le `require` générera une erreur.

Après, vous pourrez manipuler la variable `$user` comme un tableau quelconque.
Par exemple :

    echo $user['login'];
    $_SESSION['user_id'] = $user['user_id'];

Vous retrouverez ce code en action dans le script `public/session-write-twig.php`.

#### Validation du champ `login`

Les erreurs à détecter :

1. le champ ne doit pas être vide
2. le login doit faire 4 caractères minimum
3. le login doit faire 100 caractères maximum
4. le login doit correspondre à celui de la variable `$user`

#### Validation du champ `password`

Les erreurs à détecter :

1. le champ ne doit pas être vide
2. le password doit faire 4 caractères minimum
3. le password doit faire 100 caractères maximum
4. le password doit correspondre à celui de la variable `$user`

Pour valider que le mot de passe correspond à celui de la variable `$user`, au lieu de faire une simple comparaison (avec `!=`), vous utiliserez la fonction `password_verify()`.
Voici un exemple d'utilisation de cette fonction :

    if (!password_verify($_POST['password'], $user['password_hash'])) {
        echo 'mauvais mot passe';
    }

#### Redirection vers la page privée

Le code suivant permet de rediriger vers la page privée :

    $url = 'private-page.php';
    header("Location: {$url}", true, 302);
    exit();

### La page privée

La page de login doit afficher :

1. un message de bienvenue du type `Hello toto`, et le nom doit être affiché en utilisant **la variable de session** (ne pas mettre `toto` en dur dans le HTML)
2. un lien vers la page `logout.php` pour se déconnecter 

Avant d'afficher la page, vous devez vérifier que l'utilisateur a bien été identifié.
S'il n'a pas été identifié, vous devez le rediriger vers la page de login.

#### Vérification de l'identité d'un client

Pour vérifier qu'un client (un navigateur) s'est bien identifié, vous pouvez vérifier si la clé `user_id` existe bien dans la variable de session.

Par exemple :

    if (isset($_SESSION['user_id'])) {
        echo "l'utilisateur est connecté";
    } else {
        echo "l'utilisateur n'est pas connecté";
    }

Mais pensez à démarrer la session avant de faire cette vérification (sinon la variable `$_SESSION` sera forcément vide) :

    session_start();

#### Redirection vers la page logout

Jetez un coup d'oeil à la section `Redirection vers la page privée`, je ne vais pas vous mâcher tout le travail non plus ;)

### La page logout

Cette page n'a pas besoin de template Twig car elle n'affiche aucune données.
Donc (logiquement) vous n'avez pas besoin du code qui permet de démarrer Twig ni du code qui permet d'afficher un template Twig.
Normalement, seules quelques lignes de code suffisent, ne soyez pas étonné si le fichier est riquiqui.

Par contre, après avoir vidé et détruit la variable de session, n'oubliez pas de rediriger l'utilisateur vers la page de login (sinon il va juste voir une page blanche, ce qui n'est pas très user friendly).

#### Redirection vers la page de login

À ce stade votre cerveau devrait rester bloqué dans une boucle infinie, à moins de faire `CTRL C`.

Voir la section `Redirection vers la page de login`.

## Support

Vous pouvez vous inspirez des scripts suivants pour réaliser l'exo :

- `contact-twig.php` et son template pour la validation de données de formulaire
- `session-private-twig.php` et son template pour le filtrage d'utilisateur non autorisé
- `session-read-twig.php` et son template pour l'affichage de données d'un tableau dans un template
- `session-write-twig.php` pour l'écriture dans la variable de sessions
- `session-clear-twig.php` pour la destruction de la variable de session (nécessaire pour le logout)

