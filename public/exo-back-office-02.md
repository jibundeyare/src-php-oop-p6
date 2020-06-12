# Exo back office

## Objectif

Ajouter des fonctionnalités au back office qui permettent d'effectuer une partie des tâches de gestion d'articles d'un catalogue :

- modifier un article existant
- supprimer un article existant

## Mission

Vous devrez créer plusieurs scripts PHP et templates Twig :

- la page de modification d'un article existant `public/article-edit.php` et son template `templates/article-edit.html.twig`
- la page de suppression d'un article existant `public/article-delete.php` (mais pas son template)
- la page d'erreur 404 article non trouvé `public/article-404.php` et son template `templates/article-404.html.twig`

Vous devez aussi modifier le script `public/articles.php` afin qu'il affiche les liens permattant de modifier ou supprimer un article existant.

Vous êtes libre d'utiliser bootstrap ou un autre framework CSS mais dans tout les cas vous devez soigner l'apparence.
Les templates Twig en HTML brut sans aucune feuille de style sont refusés.

### Vérifier l'existance d'un article dans la base de données

Dans cet exercice, nous n'utilisons pas de base de données MySQL.

Pour vérifier qu'un article existe, nous ne pouvons donc pas utiliser de requête SQL.

À la place nous utiliserons une fonctions qui prend en paramètre la liste des articles et un id et quii renvoit l'article s'il existe, ou la valeur `false` si l'article n'existe pas (un peu comme la fonctione `strpos()` qui permet de recherche une chaîne de caractères dans une autre chaîne de caractères).

Voici la signature de la fonction :

    articleExists(int $id, array $articles): bool

Si vous le voulez, vous pouvez écrire cette fonction vous-même.
Dans ce cas, pensez-à définir la fonction dans un fichier séparé et précisez que vous en êtes l'auteur(e) avec un commentaire dans le code source de la fonction.

Sinon vous pouvez utiliser celle que j'ai préparé avec le code suivant :

    require __DIR__.'/articles-lib.php';

**Attention** : copiez le fichier `public/articles-lib.php` dans le  dossier `public` votre de projet, sinon le `require` générera une erreur.

### La page qui liste les articles existants

Vous devez modifier cette page en ajoutant une nouvelle colonne nommée `actions` dans le tableau HTML.

Cette colonne doit contenir deux liens :

1. un lieu qui permet de modifier l'article, de la forme :

    <a href="/article-edit.php?id={{ article.id }}">modifier</a>

2. un lieu qui permet de supprimer l'article, de la forme :

    <a href="/article-delete.php?id={{ article.id }}">supprimer</a>

### Récupérer l'id depuis l'URL

L'id est précisé dans l'URL grâce à une requête HTTP de type GET.
Pour récupérer l'id il suffit donc d'utiliser la variable `$_GET`, un peu comme on utilise la variable `$_POST`.

Par contre, il n'est pas la peine de vérifier si `$_GET` est non vide, si la clé `id` n'existe pas, il y a forcément une erreur. 

    if (!isset($_GET['id']) || empty($_GET['id'])) {
        // aucun id n'est spécifié
    } elseif (!articleExists($_GET['id'], $articles)) {
        // l'article n'existe pas
    }

En cas d'erreur, vous pouvez simplement renvoyer l'utilisateur vers la page d'erreur 404 article non trouvé `public/article-404.php`.

### La page de modification d'un article existant

Cette page doit :

- renvoyer vers la page `public/article-404.php` si l'article n'existe pas
- afficher dans un formulaire HTML les champs de l'article sélectionné
- afficher un lien vers la page qui liste tous les articles existants

Voici la liste des champs à afficher dans le formulaire HTML :

1. `id` : l'id de l'article (mais ce champ ne doit pas être modifiable)
2. `description` : la description de l'article
3. `name` : le nom de l'article
4. `price` : le prix de l'article
5. `quantity` : la quantité de l'article

Les données du formulaire doivent être envoyée avec la méthode `post`.

Cette page doit traiter les données du formulaire renvoyées par l'utilisateur :

1. vérifier si la variable `$_POST` est vide
2. valider les données du formulaire (`name`, `description`, `price` et `quantity`)
3. s'il y a une erreur pour un champ, il faut afficher une erreur spécifique pour ce champ (par exemple `merci de renseigner le nom de l'article`)
4. s'il n'y a pas d'erreurs, rediriger l'utilisateur vers la page qui liste les articles existants. (Normalement il faudrait créer l'article en base de données et afficher un message de confirmation mais on ne va pas le faire dans cet exercice.)

Pour la validation des champs ou la redirection, voir l'exo précédent [exo-back-office-01.md](exo-back-office-01.md).

### La page de suppression d'un article existant

Cette page doit :

- renvoyer vers la page d'erreur 404 article non trouvé `public/article-404.php` si l'article n'existe pas
- renvoyer vers la page qui liste les articles existants `public/articles.php` si l'article existe pas. (Normalement il faudrait supprimer l'article de la base de données et afficher un message de confirmation mais on ne va pas le faire dans cet exercice.)

Pour la redirection, voir l'exo précédent [exo-back-office-01.md](exo-back-office-01.md).

### La page d'erreur 404 article non trouvé

Cette page doit simplement afficher le message d'erreur `erreur 404 article non trouvé`et afficher un lien permettant de revenir à la page qui liste les articles existants.
