# Exo back office

## Objectif

Mettre en place un back office qui permet d'effectuer une partie des tâches de gestion d'articles d'un catalogue :

- afficher la liste des articles existants
- ajouter un nouvel article

## Mission

Vous devrez créer plusieurs scripts PHP et templates Twig :

- la page qui liste les articles existants `public/articles.php` et son template `templates/articles.html.twig`
- la page qui permet d'ajouter un nouvel article `public/article-new.php` et son template `templates/article-new.html.twig`

Vous êtes libre d'utiliser bootstrap ou un autre framework CSS mais dans tout les cas vous devez soigner l'apparence.
Les templates Twig en HTML brut sans aucune feuille de style sont refusés.

### La base de données des articles

Dans cet exercice, nous n'utilisons pas de base de données MySQL.
À la place nous utilisons un fichier PHP qui contient toutes les données nécessaires sous forme de tableau PHP.

Pour récupérer les données des articles, vous pouvez utiliser le code suivant :

    $articles = require __DIR__.'/articles-data.php';

**Attention** : copiez le fichier `public/articles-data.php` dans le  dossier `public` votre de projet, sinon le `require` générera une erreur.

Après, vous pourrez manipuler la variable `$articles` comme un tableau quelconque.
Par exemple, en PHP :

    foreach ($articles as $article) {
        echo $article['id'];
        echo $article['name'];
        echo $article['description'];
        echo $article['price'];
        echo $article['quantity'];
    }

Autre exemple, en Twig :

    {{ for article in articles }}
        {{ article.id }}
        {{ article.name }}
        {{ article.description }}
        {{ article.price }}
        {{ article.quantity }}
    {{ endfor }}

### La page qui liste les articles existants

Cette page doit :

- afficher dans un tableau HTML la liste de tous les articles
- afficher un lien vers la page qui permet d'ajouter un nouvel article

Voici la liste des colonnes à afficher dans le tableau HTML :

1. `id` : l'id de l'article
2. `name` : le nom de l'article
3. `price` : le prix de l'article
4. `quantity` : la quantité de l'article

### La page qui permet d'ajouter un nouvel article

Cette page doit afficher un formulaire HTML avec les champs suivants :

1. `name` : le nom de l'article
2. `description` : la description de l'article
3. `price` : le prix de l'article
4. `quantity` : la quantité de l'article

Les données du formulaire doivent être envoyée avec la méthode `post`.

Cette page doit traiter les données du formulaire renvoyées par l'utilisateur :

1. vérifier si la variable `$_POST` est vide
2. valider les données du formulaire (`name`, `description`, `price` et `quantity`)
3. s'il y a une erreur pour un champ, il faut afficher une erreur spécifique pour ce champ (par exemple `merci de renseigner le nom de l'article`)
4. s'il n'y a pas d'erreurs, rediriger l'utilisateur vers la page qui liste les articles existants. (Normalement il faudrait créer l'article en base de données et afficher un message de confirmation mais on ne va pas le faire dans cet exercice.)

#### Validation du champ `name`

Les erreurs à détecter :

1. le champ ne doit pas être vide
2. le name doit faire 2 caractères minimum
3. le name doit faire 100 caractères maximum

#### Validation du champ `description`

Ce champ est optionnel, il a donc le droi d'être vide.
Mais s'il n'est pas vide il faut détecter les erreurs suivantes :

1. la description ne doit pas contenir les caractères `<` et `>`

Voici un exemple de validation d'un champ optionnel :

    if (isset($_POST['description'])) {
        if (
            strpos($_POST['description'], '<')
            || strpos($_POST['description'], '>')
        ) {
            // la description contient un caractère interdit < ou >
        }
    }

#### Validation du champ `price`

Les erreurs à détecter :

1. le champ ne doit pas être vide
2. le prix doit être une valeur numérique (`int` ou `float`, peu importe)

Vous pouvez utiliser la fonction `is_numeric()` dans un bloc `if` pour vérifier si une variable contient un nombre.

#### Validation du champ `quantity`

Les erreurs à détecter :

1. le champ ne doit pas être vide
2. la quantité doit être un nombre entier (pas de `float`)
3. la quantité doit être supérieure ou égale à zéro

Vous pouvez utiliser la fonction `is_int()` dans un bloc `if` pour vérifier si une variable contient un nombre entier.

#### Redirection vers la page qui liste les articles existants

Le code suivant permet de rediriger vers la page qui liste les articles existants :

    $url = 'articles.php';
    header("Location: {$url}", true, 302);
    exit();

