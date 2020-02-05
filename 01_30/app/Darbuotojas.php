<?php
/**
 * Created by PhpStorm.
 * User: moksleivis
 * Date: 2020-01-30
 * Time: 13:34
 */

namespace OOP;

class Darbuotojas extends Narys {
    private $profesija;

    public function __construct($vardas, $pavarde, $profesija = null)
    {
        parent::__construct($vardas, $pavarde);
        $this->profesija = $profesija;
    }

    public function setProfesija($profesija) {
        $this->profesija = $profesija;
    }

    public function getProfesija() {
        return $this->profesija;
    }

    public function getAll() {
        $data['vardas'] = $this->vardas;
        $data['pavarde'] = $this->pavarde;
        $data['profesija'] = $this->profesija;

        return $data;
    }
}