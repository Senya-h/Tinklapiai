<?php
$genres = db_query_get_all("SELECT * FROM genres");

$errors = [];
$success = false;

if(isset($_POST["submit"])) {
    $_POST = validateAll($_POST);
    $errors = checkForMovieInputErrors($_POST);

    if(empty($errors)) {
        $query = "INSERT INTO movies(id, title, description, year,
                director, imdb, genre_id)
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        $params = [
            "NULL", $_POST["title"], $_POST["description"],
            $_POST["year"], $_POST["director"], $_POST["imdb"], $_POST["genre_id"]
        ];

        $success = db_query_params_set($query, $params);

//        header("Location: $internetPath?page=visi");
//        die();
    }
}
?>

<?php if($errors):?>
    <div class="container bg-danger text-white mt-3">
        <ul>
            <?php foreach($errors as $error):?>
                <li><?=$error;?></li>
            <?php endforeach;?>
        </ul>
    </div>
<?php elseif($success):?>
    <div class="container">
        <h1 class="mt-5">Filmas sėkmingai pridėtas!</h1>
    </div>
<?php endif;?>


<div class="container mt-3">
    <h2>Filmų pridėjimas</h2>
    <form class="mt-3" method="POST">
        <div class="form-group">
            <input type="text" name="title" class="form-control" placeholder="Filmo pavadinimas">
        </div>
        <div class="form-group">
            <textarea type="text" name="description" class="form-control" rows="4" placeholder="Aprašymas"></textarea>
        </div>
        <div class="form-group">
            <input type="text" name="year" class="form-control" placeholder="Metai">
        </div>
        <div class="form-group">
            <input type="text" name="director" class="form-control" placeholder="Režisierius">
        </div>
        <div class="form-group">
            <input type="text" name="imdb" class="form-control" placeholder="IMDB">
        </div>
        <select class="form-group custom-select" name="genre_id" >
            <option value="" selected hidden>Pasirinkite žanrą</option>
            <?php foreach($genres as $genre):?>
                <option value="<?=$genre['id'];?>"><?=$genre['genre'];?></option>
            <?php endforeach;?>
        </select>
    <button type="submit" name="submit" class="btn btn-primary">Pridėti filmą</button>
    </form>
</div>