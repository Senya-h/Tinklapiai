<?php
if(!isset($_SESSION)) {
    session_start();
}

if(!isset($_POST['username'])) {
    $_POST['username'] = "anonymous";
}

if(isset($_POST['login'])) {
    if($_POST['username'] === 'admin') {
        $query = 'SELECT * FROM users WHERE users.username = ?';
        $userInfo = db_query_get_one($query, [$_POST['username']]);

        if(password_verify(trim($_POST['password']), $userInfo['password'])) {
            $_SESSION['username'] = 'admin';
            header("Location: ?page=filmu-valdymas");
        } else {
            echo "<br>" . "prisijungti nepavyko";
        }
    }
}

if(isset($_POST['logout'])) {
    $_SESSION['username'] = 'anonymous';
}
?>


<div class="container mt-3">
<?php if($_SESSION['username'] === 'anonymous'):?>
    <form method="POST">
        <div class="form-group">
            <input type="text" name="username" class="form-control" placeholder="Prisijungimo vardas">
        </div>
        <div class="form-group">
            <input type="password" name="password" class="form-control" placeholder="Slaptažodis">
        </div>
        <button type="submit" name="login" class="btn btn-primary mt-2">Prisijungti</button>
    </form>
<?php else:?>
    <form method="POST">
        <button type="submit" name="logout" class="btn btn-primary">Atsijungti</button>
    </form>
<?php endif;?>
</div>
