<?php

$genres = db_query_get_all("SELECT * FROM genres");

if(isset($_GET["id"])) {
    $query = "SELECT movies.title, movies.description, movies.year,
              movies.director, movies.imdb, genres.genre FROM movies JOIN genres 
              ON movies.genre_id = genres.id
              WHERE movies.genre_id = ?";

    $movies = db_query_get_all($query, [$_GET['id']]);
}
?>

<div class="container">
    <h2 class="mt-3">Pasirinkite žanrą</h2>

    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Žanrai
        </button>

        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <?php foreach($genres as $genre):?>
                <a class="dropdown-item" href="?page=zanrai&id=<?=$genre['id'];?>"><?=$genre['genre'];?></a>
            <?php endforeach;?>
        </div>
    </div>

    <?php if(isset($_GET['id'])):?>
    <table class="table table-bordered bg-light table-hover mt-3">
        <tr>
            <th>Pavadinimas</th>
            <th>Aprašymas</th>
            <th>year</th>
            <th>Režisierius</th>
            <th>IMDB</th>
            <th>Žanras</th>
        </tr>

        <?php foreach($movies as $movie):?>
        <tr>
            <td><?=$movie['title'];?></td>
            <td><?=$movie['description'];?></td>
            <td><?=$movie['year'];?></td>
            <td><?=$movie['director'];?></td>
            <td><?=$movie['imdb'];?></td>
            <td><?=$movie['genre'];?>  </td>
        </tr>
        <?php endforeach;?>
    </table>
    <?php endif;?>
</div>
