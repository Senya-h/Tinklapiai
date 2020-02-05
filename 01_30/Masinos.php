<?php
class Transportas {
    protected $modelis, $marke, $kaina, $svoris, $yraVariklis, $variklioGalingumas;
    protected $maxGreitis, $aprasymas, $zmoniuTalpa;
    protected $nustatytosReiksmes = [
            "Modelis" => "",
            "Marke" => "",
            "Kaina" => "",
            "Svoris kg" => "",
            "Variklis" => "",
            "Variklio Galingumas kW" => "",
            "Maksimalus Greitis km/h" => "",
            "Aprasymas" => "",
            "Zmoniu Talpa" => "",
    ];

    protected function __construct($modelis, $marke) {
        $this->modelis = $modelis;
        $this->marke = $marke;

        $this->nustatytosReiksmes["Modelis"] = $this->modelis;
        $this->nustatytosReiksmes["Marke"] = $this->marke;
    }

    public function setModelis($modelis) {
        $this->modelis = $modelis;
        $this->nustatytosReiksmes["Modelis"] = $this->modelis;
    }

    public function setMarke($marke) {
        $this->marke = $marke;
        $this->nustatytosReiksmes["Marke"] = $this->marke;
    }

    public function setKaina($kaina) {
        $this->kaina = $kaina;
        $this->nustatytosReiksmes["Kaina"] = $this->kaina;
    }

    public function setSvoris($svoris) {
        $this->svoris = $svoris;
        $this->nustatytosReiksmes["Svoris kg"] = $this->svoris;
    }

    public function setYraVariklis($yraVariklis) {
        $this->yraVariklis = $yraVariklis;
        if($yraVariklis) {
            $this->nustatytosReiksmes["Variklis"] = "Yra";
        } else {
            $this->nustatytosReiksmes["Variklis"] = "Nera";
        }

    }

    public function setVariklioGalingumas($variklioGalingumas) {
        if($this->yraVariklis == "Yra") {
            $this->variklioGalingumas = $variklioGalingumas;
            $this->nustatytosReiksmes["Variklio Galingumas kW"] = $variklioGalingumas;
        } else {
            echo "Variklio si transporto priemone neturi :)";
        }
    }

    public function setMaxGreitis($maxGreitis) {
        $this->maxGreitis = $maxGreitis;
        $this->nustatytosReiksmes["Maksimalus Greitis km/h"] = $this->maxGreitis;
    }

    public function setAprasymas($aprasymas) {
        $this->aprasymas = $aprasymas;
        $this->nustatytosReiksmes["Aprasymas"] = $this->aprasymas;
    }

    public function setZmoniuTalpa($zmoniuTalpa) {
        $this->zmoniuTalpa = $zmoniuTalpa;
        $this->nustatytosReiksmes["Zmoniu Talpa"] = $this->zmoniuTalpa;
    }


    public function getModelis() {
        return $this->modelis;
    }

    public function getMarke() {
        return $this->marke;
    }

    public function getKaina() {
        return $this->kaina;
    }

    public function getSvoris() {
        return $this->svoris;
    }

    public function getYraVariklis() {
        return $this->yraVariklis;
    }

    public function getVariklioGalingumas() {
        return $this->variklioGalingumas;
    }

    public function getMaxGreitis() {
        return $this->maxGreitis;
    }

    public function getAprasymas() {
        return $this->aprasymas;
    }

    public function getZmoniuTalpa() {
        return $this->zmoniuTalpa;
    }

    public function getAll() {
        return $this->nustatytosReiksmes;
    }
}

class Dviratis extends Transportas {
    private $ratai;

    public function __construct($modelis, $marke, $ratai)
    {
        parent::__construct($modelis, $marke);
        $this->ratai = $ratai;
        $this->nustatytosReiksmes["Ratai"] = $ratai;

    }

    private function setRatai($ratai) {
        $this->ratai = $ratai;
        $this->nustatytosReiksmes["Ratai"] = $ratai;

    }

    private function getRatai() {
        return $this->ratai;
    }
}

class Automobilis extends Transportas {
    private $bakas;

    public function __construct($modelis, $marke, $bakas)
    {
        parent::__construct($modelis, $marke);
        $this->bakas = $bakas;
        $this->nustatytosReiksmes["Bakas"] = $bakas;
    }

    private function setBakas($bakas) {
        $this->bakas = $bakas;
        $this->nustatytosReiksmes["Bakas"] = $bakas;
    }

    private function getBakas() {
        return $this->bakas;
    }
}

class Motociklas extends Transportas {
    private $arGrazus;

    public function __construct($modelis, $marke, $arGrazus)
    {
        parent::__construct($modelis, $marke);
        $this->arGrazus = $arGrazus;
        $this->nustatytosReiksmes["Ar grazus"] = $arGrazus;
    }

    private function setArGrazus($arGrazus) {
        $this->arGrazus = $arGrazus;
        $this->nustatytosReiksmes["Ar grazus"] = $arGrazus;
    }

    private function getArGrazus() {
        return $this->arGrazus;
    }
}

$dviratis = new Dviratis("Dviracio modelis", "Dviracio marke", 2);
$automobilis = new Automobilis("Automobilio modelis", "Automobilio marke", 200);
$motociklas = new Motociklas("Motociklo modelis", "Motociklo marke", "Taip");
$dviratis->setYraVariklis(false);
?>

<h2>Automobilis:</h2>
<ul>
    <?php foreach($automobilis->getAll() as $item => $value):?>
        <li><span><?=$item . ": ";?></span><?=$value;?></li>
    <?php endforeach;?>
</ul>

<h2>Dviratis:</h2>
<ul>
    <?php foreach($dviratis->getAll() as $item => $value):?>
        <li><span><?=$item . ": ";?></span><?=$value;?></li>
    <?php endforeach;?>
</ul>

<h2>Motociklas:</h2>
<ul>
    <?php foreach($motociklas->getAll() as $item => $value):?>
        <li><span><?=$item . ": ";?></span><?=$value;?></li>
    <?php endforeach;?>
</ul>

