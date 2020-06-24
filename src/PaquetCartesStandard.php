<?php

namespace App;

use App\Carte;
use App\CartesArray;

class PaquetCartesStandard extends CartesArray
{
    public function __construct()
    {
        foreach (Carte::FIGURES as $codeFigure => $nomFigure) {
            for ($i = Carte::AS; $i <= Carte::ROI; $i++) {
                if ($codeFigure == 0 ||$codeFigure == 1) {
                    $couleur = Carte::NOIR;
                } else {
                    $couleur = Carte::ROUGE;
                }
    
                $carte = new Carte($couleur, $codeFigure, $i);

                $this->cartes[] = $carte;
            }
        }
    }
}