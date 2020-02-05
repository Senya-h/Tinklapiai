<?php
/**
 * Created by PhpStorm.
 * User: moksleivis
 * Date: 2020-01-30
 * Time: 13:37
 */

namespace OOP;


class Mokytojas extends Narys{

    private $dalykas;

    public function __construct($vardas, $pavarde, $dalykas)
    {
        parent::__construct($vardas, $pavarde);
        $this->dalykas = $dalykas;
    }

    public function setDalykas($dalykas) {
        $this->dalykas = $dalykas;
    }

    public function getDalykas() {
        return $this->dalykas;
    }

    public function getAll() {
        $data['vardas'] = $this->vardas;
        $data['pavarde'] = $this->pavarde;
        $data['dalykas'] = $this->dalykas;

        return $data;
    }
}