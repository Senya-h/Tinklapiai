<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="view/style.css">
    <title><?=siteName;?></title>
</head>
<body>
<?php

$klaidosPranesimai = [];

if(isset($_POST["spausdinti"])) {
    if($_POST["skrydzioNr"]) {
        $_POST["skrydzioNr"] = htmlspecialchars($_POST["skrydzioNr"]);
    }
    if($_POST["iKurSkrenda"]) {
        $_POST["iKurSkrenda"] = htmlspecialchars($_POST["iKurSkrenda"]);
    }
    if($_POST["bagazas"]) {
        $_POST["bagazas"] = htmlspecialchars($_POST["bagazas"]);
    }

    $_POST["kaina"] = htmlspecialchars($_POST["kaina"]);
    $_POST["vardas"] = htmlspecialchars($_POST["vardas"]);
    $_POST["pavarde"] = htmlspecialchars($_POST["pavarde"]);
    $_POST["asmensKodas"] = htmlspecialchars($_POST["asmensKodas"]);
    $_POST["pastabos"] = htmlspecialchars($_POST["pastabos"]);

    $_POST["vardas"] = trim($_POST["vardas"]);
    $_POST["pavarde"] = trim($_POST["pavarde"]);
    $_POST["asmensKodas"] = trim($_POST["asmensKodas"]);
    $_POST["pastabos"] = trim($_POST["pastabos"]);
    $_POST["kaina"] = trim($_POST["kaina"]);

    if(empty($_POST["skrydzioNr"])) {
        $klaidosPranesimai[] = "Skrydzio numeris turi buti parinktas";
    }

    if(empty($_POST["iKurSkrenda"])) {
        $klaidosPranesimai[] = "Skrydzio kryptis turi buti parinktas";
    }

    if(empty($_POST["bagazas"])) {
        $klaidosPranesimai[] = "Bagazo svoris turi buti parinktas";
    }

    if(!preg_match('/^[0-9]*$/', $_POST["kaina"])) {
        $klaidosPranesimai[] = "Kaina turi buti nustatyta";
    }

    if(!preg_match('/^[a-zA-Z]{2,100}$/', $_POST["vardas"])) {
        $klaidosPranesimai[] = "Vardas turi buti tarp 2 ir 100 simboliu ir tik raides";
    }

    if(!preg_match('/^[a-zA-Z]{2,100}$/', $_POST["pavarde"])) {
        $klaidosPranesimai[] = "Pavarde turi buti tarp 2 ir 100 simboliu ir tik raides";
    }

    if(!preg_match("/^[34](\d{2}(0[1-9]|1[0-2])(0[1-9]|[12]\d|3[01])\d{4}$)/", $_POST["asmensKodas"])) {
        $klaidosPranesimai[] = "Asmens kodas turi atitikti lietuviska formata";
    }

    if(!preg_match("/^.{0,100}$/", $_POST["pastabos"])) {
        $klaidosPranesimai[] = "Pastabos ilgis turi buti iki 100 simboliu";
    }

}

?>
<?php if($klaidosPranesimai):?>
<div class="container text-white" id="klaidosLaukelis">
    <ul>
        <?php foreach($klaidosPranesimai as $klaida):?>
            <li><?=$klaida;?></li>
        <?php endforeach;?>
    </ul>
</div>
<?php elseif(isset($_POST["spausdinti"])):?>
    <div class="container">
        <div class="container bg-warning">
            <div class="row">

                <div class="col-8">
                    <div class="row">
                        <p class="col-12 bg-secondary text-white">Kauno oro uostas</p>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <p>Vardas: <?=$_POST["vardas"];?></p>
                            <p>Vardas: <?=$_POST["pavarde"];?></p>
                            <p>Asmens kodas: <?=$_POST["asmensKodas"];?></p>
                            <p>Bagazo svoris: <?=$_POST["bagazas"];?> kg</p>
                            <p>Pastabos: <?=$_POST["pastabos"];?></p>
                        </div>
                        <div class="col-6">
                            <p>Skrydzio numeris: <?=$_POST["skrydzioNr"];?></p>
                            <p>Skrydis is: <?=$_POST["isKurSkrenda"];?></p>
                            <p>Skrydis i: <?=$_POST["iKurSkrenda"];?></p>
                        </div>
                    </div>

                </div>


                <div class="col-4 bg-secondary text-white d-flex flex-column justify-content-center align-items-center">
                    <p>Skrydzio kaina: <?=$_POST["kaina"];?> EUR</p>
                    <?php if($_POST["bagazas"] > 20):?>
                        <p>Bagazo kaina: 30 EUR</p>
                        <p>Is viso: <?=$_POST["kaina"] + 30;?> EUR</p>
                    <?php else:?>
                        <p>Bagazo kaina: 0 EUR</p>
                        <p>Is viso: <?=$_POST["kaina"];?> EUR</p>
                    <?php endif;?>

                    <p>Linkime grazios keliones!</p>
                </div>

            </div>
        </div>

        <a href="index.php">Spausdinti nauja bilieta</a>
    </div>
<?php endif;?>

<?php if(!isset($_POST["spausdinti"]) || $klaidosPranesimai):?>
<div class="container">
    <form method="POST" class="mt-5">
        <div class="form-group">
            <select name="skrydzioNr" class="form-control">
                <option selected disabled value="">--Skrydzio numeris--</option>
                <option value="<?=$skrydzioInformacija['skrydzioNr'];?>"><?=$skrydzioInformacija['skrydzioNr'];?></option>
            </select>
        </div>
        <div class="form-group">
            <select name="isKurSkrenda" class="form-control">
                <option selected value="<?=$skrydzioInformacija['isKurSkrenda'];?>"><?=$skrydzioInformacija['isKurSkrenda'];?></option>
            </select>
        </div>
        <div class="form-group">
            <select name="iKurSkrenda" class="form-control">
                <option selected disabled value="">--I kur skrenda--</option>
                <?php foreach($skrydzioInformacija['iKurSkrenda'] as $kryptis):?>
                    <option value="<?=$kryptis;?>"><?=$kryptis;?></option>
                <?php endforeach;?>
            </select>
        </div>
        <div class="form-group">
            <select name="bagazas" class="form-control">
                <option selected disabled value="">--Bagazas--</option>
                <?php foreach($skrydzioInformacija['bagazas'] as $bagazas):?>
                    <option value="<?=$bagazas;?>"><?=$bagazas;?></option>
                <?php endforeach;?>
            </select>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="asmensKodas" placeholder="Asmens kodas">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="vardas" placeholder="Vardas">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="pavarde" placeholder="Pavarde">
        </div>

        <div class="form-group">
            <input type="number" class="form-control" name="kaina" placeholder="Kaina">
            <small class="form-text text-muted">Jei svoris didesnis uz 20kg, prie kainos prisideda 30 EUR</small>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="pastabos" placeholder="Pastabos">
        </div>
        <button type="submit" name="spausdinti" id="submitBtn" class="btn btn-primary">Spausdinti</button>
    </form>
</div>
<?php endif;?>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>