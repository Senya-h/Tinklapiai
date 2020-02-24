<?php
    if(!isset($_SESSION)) {
        session_start();
    }
?>

<?php if($_SESSION['username'] === 'admin'):?>
<div class="container mt-3">
    <a class="btn btn-primary" href="?page=filmu-valdymas&add">Filmų pridėjimas</a>
    <a class="btn btn-primary" href="?page=filmu-valdymas&edit">Filmų redagavimas</a>
    <?php
        if(isset($_GET["add"])) {
            require("add_movie.page.php");
        } elseif(isset($_GET["edit"])) {
            require("edit_movie.page.php");
        }
    ?>
</div>
<?php else:?>
    <?php
        include("login.page.php");
    ?>
<?php endif;?>