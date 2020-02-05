<?php
/**
 * Created by PhpStorm.
 * User: moksleivis
 * Date: 2020-01-30
 * Time: 13:32
 */

namespace OOP;


abstract class Narys{
    protected $vardas, $pavarde;

    abstract function __construct($vardas, $pavarde);

    abstract public function getAll();

    public function getVardas() {
        return $this->vardas;
    }

    public function getPavarde() {
        return $this->pavarde;
    }

    public function setVardas($vardas) {
        $this->vardas = $vardas;
    }

    public function setPavarde($pavarde) {
        $this->pavarde = $pavarde;
    }
}