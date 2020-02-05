<?php
    if(!isset($_SESSION)) {
        session_start();
    }
    $genres = db_query_get_all("SELECT * FROM genres");
    $errors = [];

    if(isset($_POST['submit'])) {
        $errors = db_add_genre($_POST);
        if(!$errors) {
            $genres = db_query_get_all("SELECT * FROM genres");
        }
    };
?>
<?php if($_SESSION['username'] === 'admin'):?>
<?php if($errors):?>
    <ul>
        <?php foreach($errors as $error):?>
            <li><?=$error;?></li>
        <?php endforeach;?>
    </ul>
<?php endif;?>

<div class="container mt-3">
    <a class="btn btn-primary" id="addGenreBtn" href="#">Pridėti naują žanrą</a>
    <form class="mt-3" method="POST">
        <table class="table table-bordered bg-light table-hover">
            <thead>
                <tr>
                    <th>Žanras</th>
                    <th>Veiksmai</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($genres as $genre):?>
                    <tr class="genre-data">
                        <td class="d-none">
                            <input type="hidden" name="genres[<?=$genre['id'];?>][id]" value="<?=$genre['id'];?>">
                            <input class="delete" type="hidden" name="genres[<?=$genre['id'];?>][change]" value="">
                        </td>
                        <td>
                            <input type="hidden" name='genres[<?=$genre['id'];?>][genre]' value="<?=$genre['genre'];?>">
                            <div>
                                <?=$genre['genre'];?>
                            </div>
                        </td>
                        <td class="change">
                            <a class="btn btn-danger" href="#">Pašalinti</a>
                        </td>
                    </tr>
                <?php endforeach;?>
            </tbody>
        </table>
        <button type="submit" name="submit" class="btn btn-primary">Patvirtinti pakeitimus</button>
    </form>
</div>

<script src="../01_20/templates/main/js/editGenres.js"></script>
<?php else:?>
    <?php
        include("login.page.php");
    ?>
<?php endif;?>