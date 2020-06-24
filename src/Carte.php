<?php

namespace App;

use \Exception;

class Carte
{
    // couleur
    const ROUGE = 0;
    const NOIR = 1;

    const COULEURS = [
        0 => 'rouge',
        1 => 'noir',
    ];

    // figures
    const TREFLE = 0;
    const PIQUE = 1;
    const COEUR = 2;
    const CARREAU = 3;

    const FIGURES = [
        0 => 'trefle',
        1 => 'pique',
        2 => 'coeur',
        3 => 'carreau',
    ];

    // têtes
    const AS = 1;
    const VALET = 11;
    const REINE = 12;
    const ROI = 13;

    const TETES = [
        1 => 'as',
        11 => 'valet',
        12 => 'reine',
        13 => 'roi',
    ];

    private $couleur;
    private $valeur;
    private $figure;  

    public function __construct(int $couleur, int $figure, int $valeur)
    {
        if ($valeur > SELF::ROI) {
            // erreur : la valeur est supérieur à 13
            throw new Exception("la valeur {$valeur} est supérieur à la valeur maximum ".SELF::ROI);
        } elseif ($valeur < SELF::AS) {
            // erreur : la valeur est inférieur à 1
            throw new Exception("la valeur {$valeur} est inférieur à la valeur minimum ".SELF::AS);
        }

        $this->couleur = $couleur;
        $this->figure = $figure;
        $this->valeur = $valeur;
    }

    /**
     * Get the value of couleur
     */ 
    public function getCouleur(): int
    {
        return $this->couleur;
    }

    /**
     * Get the value of figure
     */ 
    public function getFigure(): int
    {
        return $this->figure;
    }

    /**
     * Get the value of valeur
     */ 
    public function getValeur(): int
    {
        return $this->valeur;
    }

    public function __toString(): string
    {
        $nom = '';

        // est-ce que la carte est une tête ?
        if (isset(SELF::TETES[$this->valeur])) {
            // c'est une tête
            $nom .= SELF::TETES[$this->valeur];
        } else {
            // ce n'est pas une tête
            $nom .= $this->valeur;
        }

        $nom .= ' de ';
        $nom .= SELF::FIGURES[$this->figure];

        return $nom;
    }
}