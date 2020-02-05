<?php
    require "vendor/autoload.php";
    use OOP\Teacher;
    use OOP\Mokinys, OOP\Darbuotojas, OOP\Mokytojas;
    use OOP\Spausdintuvas;

if(isset($_POST['submitStudent'])) {
    $mokinys = new Mokinys($_POST['name'], $_POST['surname'], $_POST['class']);
    Spausdintuvas::spausdinti($mokinys->getAll());
}
if(isset($_POST['submitWorker'])) {
    $darbuotojas = new Darbuotojas($_POST['name'], $_POST['surname'], $_POST['profession']);
    Spausdintuvas::spausdinti($darbuotojas->getAll());
}
if(isset($_POST['submitTeacher'])) {
    $mokytojas = new Mokytojas($_POST['name'], $_POST['surname'], $_POST['subject']);
    Spausdintuvas::spausdinti($mokytojas->getAll());
}
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Hello, world!</title>
</head>
<body>


<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-3">
            <form method="POST">
                <h2>Mokinys:</h2>
                <div class="form-group">
                    <label for="exampleInputEmail1">Vardas</label>
                    <input type="text" name="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Vardas">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Pavarde</label>
                    <input type="text" name="surname" class="form-control" id="exampleInputPassword1" placeholder="Pavarde">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Klase</label>
                    <input type="text" name="class" class="form-control" id="exampleInputPassword1" placeholder="Klase">
                </div>
                <button type="submit" name="submitStudent" class="btn btn-primary">Submit</button>
            </form>
        </div>

        <div class="col-3">
            <form method="POST">
                <h2>Darbuotojas:</h2>
                <div class="form-group">
                    <label for="exampleInputEmail1">Vardas</label>
                    <input type="text" name="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Vardas">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Pavarde</label>
                    <input type="text" name="surname" class="form-control" id="exampleInputPassword1" placeholder="Pavarde">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Profesija</label>
                    <input type="text" name="profession" class="form-control" id="exampleInputPassword1" placeholder="Klase">
                </div>
                <button type="submit" name="submitWorker" class="btn btn-primary">Submit</button>
            </form>
        </div>

        <div class="col-3">
            <form method="POST">
                <h2>Mokytojas:</h2>
                <div class="form-group">
                    <label for="exampleInputEmail1">Vardas</label>
                    <input type="text" name="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Vardas">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Pavarde</label>
                    <input type="text" name="surname" class="form-control" id="exampleInputPassword1" placeholder="Pavarde">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Dalykas</label>
                    <input type="text" name="subject" class="form-control" id="exampleInputPassword1" placeholder="Klase">
                </div>
                <button type="submit" name="submitTeacher" class="btn btn-primary">Submit</button>
            </form>
        </div>

    </div>

</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>

