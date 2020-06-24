<?php

namespace App;

use App\Carte;

class CartesArray
{
    private $cartes = [];

    public function __construct(array $cartes = [])
    {
        $this->cartes = $cartes;
    }

    public function addCarte(Carte $carte)
    {
        $this->cartes[] = $carte;

        return $this;
    }

    /**
     * Get the value of cartes
     */ 
    public function getCartes()
    {
        return $this->cartes;
    }

    /**
     * Set the value of cartes
     *
     * @return  self
     */ 
    public function setCartes($cartes)
    {
        $this->cartes = $cartes;

        return $this;
    }
}