<?php
$moviesFound = [];
$errors = "";

//Visi filmai del autocomplete
$allMovies = db_query_get_all("SELECT movies.title FROM movies");

//Galutiniai rasti filmai
if(isset($_POST["submit"])) {
    $_POST = validateAll($_POST);
    $errors = checkForMovieInputErrors($_POST);
    if($errors) {
        $errors = $errors[0];
    }

    if(empty($errors)) {
        $moviesFound = db_search_movies_get_all($_POST['title']);
    }
}
?>

<div class="container">
    <h2 class="mt-3">Filmų paieška</h2>
    <form class="mt-3" method="POST">
        <div class="form-group">
            <input type="text" list="moviesList" name="title" class="form-control" placeholder="Filmo pavadinimas" autocomplete="off">

            <datalist id="moviesList">
                <?php foreach($allMovies as $movie):?>
                    <option value="<?=$movie['title'];?>">
                <?php endforeach;?>
            </datalist>

        </div>
        <button type="submit" name="submit" class="btn btn-primary">Ieškoti filmus</button>
    </form>
</div>

<div class="container mt-4">
    <?php if(isset($_POST['submit']) && $moviesFound):?>
        <table class="table table-bordered bg-light table-hover">
            <thead>
            <tr>
                <th>Pavadinimas</th>
                <th>Aprašymas</th>
                <th>Metai</th>
                <th>Režisierius</th>
                <th>IMDB</th>
                <th>Žanras</th>
            </tr>
            </thead>
            <?php foreach($moviesFound as $movie):?>
                <tr>
                    <td><?=$movie['title'];?></td>
                    <td><?=$movie['description'];?></td>
                    <td><?=$movie['year'];?></td>
                    <td><?=$movie['director'];?></td>
                    <td><?=$movie['imdb'];?></td>
                    <td><?=$movie['genre'];?></td>
                </tr>
            <?php endforeach;?>
        </table>
    <?php elseif($errors):?>
        <h3><?=$errors;?></h3>
    <?php elseif(isset($_POST['submit']) && empty($moviesFound)):?>
        <h3>Rezultatų nerasta</h3>
<?php endif;?>