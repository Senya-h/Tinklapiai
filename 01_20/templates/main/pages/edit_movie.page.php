<?php
$allMovies = [];
$allGenres = [];
$moviesFound = [];
$errors = [];

$success = false;

//Visi filmai del autocomplete
$allMovies = db_query_get_all("SELECT title FROM movies");

//Filmu paieska ir visu zanru gavimas
if(isset($_POST["submitSearch"])) {
    $_POST = validateAll($_POST);
    $errors = checkForMovieInputErrors($_POST);

    if(empty($errors)) {
        $moviesFound = db_search_movies_get_all($_POST['title']);
        $allGenres = db_query_get_all("SELECT * FROM genres");
    }
}

//Pakeitimu patvirtinimas ir issiuntimas
if(isset($_POST['submitChanges'])) {
    $_POST['movies'] = validateEditedMovies($_POST['movies']);
    $errors = checkForEditedMoviesInputErrors($_POST['movies']);

    if(empty($errors)) {
        $success = db_update_movie($_POST['movies']);
    }
}
?>

<div class="container mt-3">
<h2>Filmų redagavimas</h2>
    <form class="mt-3" method="POST">
        <div class="form-group">
            <input list="moviesList" type="text" name="title" class="form-control" placeholder="Filmo pavadinimas" autocomplete="off">
            <datalist id="moviesList">
                <?php foreach($allMovies as $movie):?>
                <option value="<?=$movie['title'];?>">
                <?php endforeach;?>
            </datalist>
        </div>
        <button type="submit" name="submitSearch" class="btn btn-primary">Ieškoti filmus</button>
    </form>

<?php if($errors ):?>
    <ul class="mt-3">
    <?php foreach($errors as $error):?>
        <li><?=$error;?></li>
    <?php endforeach;?>
    </ul>
<?php endif;?>
<?php if($success && isset($_POST['submitChanges'])):?>
    <h3 class="mt-3">Redagavimas sėkmingas!</h3>
<?php endif;?>
<?php if( (isset($_POST['submitSearch']) || isset($_POST['submitChanges'])) && $moviesFound):?>
    <form method="POST" class="mt-3">
        <table class="table table-bordered bg-light table-hover">
        <thead>
        <tr>
            <th>Pavadinimas</th>
            <th>Aprašymas</th>
            <th>Metai</th>
            <th>Režisierius</th>
            <th>IMDB</th>
            <th>Žanras</th>
            <th>Veiksmai</th>
        </tr>
        </thead>
        <?php foreach($moviesFound as $movie):?>
            <tr class="movie-data">
                <td class="d-none">
                    <input class="idNumber" type="hidden" name="movies[<?=$movie['id'];?>][id]" value="<?=$movie['id'];?>">
                    <input class="shouldChange" type="hidden" name="movies[<?=$movie['id'];?>][change]" value="">
                </td>
                <td>
                    <input type="hidden" name='movies[<?=$movie['id'];?>][title]' value="<?=$movie['title'];?>">
                    <div>
                        <?=$movie['title'];?>
                    </div>
                </td>
                <td>
                    <input type="hidden" name='movies[<?=$movie['id'];?>][description]' value="<?=$movie['description'];?>">
                    <div>
                        <?=$movie['description'];?>
                    </div>
                </td>
                <td>
                    <input type="hidden" name='movies[<?=$movie['id'];?>][year]' value="<?=$movie['year'];?>">
                    <div>
                        <?=$movie['year'];?>
                    </div>
                </td>
                <td>
                    <input type="hidden" name='movies[<?=$movie['id'];?>][director]' value="<?=$movie['director'];?>">
                    <div>
                        <?=$movie['director'];?>
                    </div>
                </td>
                <td>
                    <input type="hidden" name='movies[<?=$movie['id'];?>][imdb]' value="<?=$movie['imdb'];?>">
                    <div>
                        <?=$movie['imdb'];?>
                    </div>
                </td>
                <td class="genre">
                    <select disabled class="custom-select" name="movies[<?=$movie['id'];?>][genre_id]">
                        <?php foreach($allGenres as $genre):?>
                            <?php if($movie['genre_id'] != $genre['id']):?>
                                <option value="<?=$genre['id'];?>"><?=$genre['genre'];?></option>
                            <?php else:?>
                                <option selected value="<?=$genre['id'];?>"><?=$genre['genre'];?></option>
                            <?php endif;?>
                        <?php endforeach;?>
                    </select>
                </td>
                <td class="text-center change">
                    <a href="#" class="btn btn-primary edit-btn">Redaguoti</a>
                    <a href="#" class="btn btn-danger">Ištrinti</a>
                </td>
            </tr>
        <?php endforeach;?>
        </table>
        <button type="submit" name='submitChanges' id="submit" class="btn btn-primary">Patvirtinti pakeitimus</button>
    </form>

<?php elseif(isset($_POST['submit']) && empty($moviesFound)):?>
    <h3>Rezultatų nerasta</h3>

<?php endif;?>
</div>

<script src="../01_20/templates/main/js/editMovies.js"></script>
