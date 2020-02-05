<?php
$query = "SELECT movies.title, movies.description, movies.year,
                              movies.director, movies.imdb, genres.genre FROM movies 
                              JOIN genres ON movies.genre_id = genres.id";
$movies = db_query_get_all($query);
?>

<div class="container">
    <h2 class="mt-3">Visi filmai</h2>
    <table class="table table-bordered bg-light table-hover mt-3">
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
        <?php foreach($movies as $movie):?>
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
</div>

