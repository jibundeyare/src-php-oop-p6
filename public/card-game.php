<?php

use App\Carte;
use App\CartesArray;
// @todo use this
use App\PaquetCartesStandard;

/**
 * Modéliser un jeu de carte.
 * 
 * Voici les classes à créer :
 * - Carte
 * - Joueur
 * - CartesArray
 */

require __DIR__.'/../vendor/autoload.php';

try {
    foreach (Carte::FIGURES as $codeFigure => $nomFigure) {
        for ($i = Carte::AS; $i <= Carte::ROI; $i++) {
            if ($codeFigure == 0 ||$codeFigure == 1) {
                $couleur = Carte::NOIR;
            } else {
                $couleur = Carte::ROUGE;
            }

            $carte = new Carte($couleur, $codeFigure, $i);

            $cartes[] = $carte;
        }
    }
} catch (Exception $e) {
    echo 'oups il y a eu une erreur<br>';
    echo $e->getMessage();
}

$pioche = new CartesArray($cartes);
dump($pioche);
