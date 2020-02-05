<?php
/**
 * Created by PhpStorm.
 * User: moksleivis
 * Date: 2020-01-30
 * Time: 13:37
 */

namespace OOP;


class Mokinys extends Narys{
    private $klase;

    public function __construct($vardas, $pavarde, $klase)
    {
        parent::__construct($vardas, $pavarde);
        $this->klase = $klase;
    }

    public function setKlase($klase) {
        $this->klase = $klase;
    }

    public function getKlase() {
        return $this->klase;
    }

    public function getAll() {
        $data['vardas'] = $this->vardas;
        $data['pavarde'] = $this->pavarde;
        $data['klase'] = $this->klase;

        return $data;
    }
}