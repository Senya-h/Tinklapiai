<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title><?=$siteName;?></title>
    <link href="/saulius/01_20/templates/main/css/bootstrap.min.css" rel="stylesheet">
    <link href="/saulius/01_20/templates/main/css/simple-sidebar.css" rel="stylesheet">
</head>
<body>
<div class="d-flex" id="wrapper">
    <!-- Sidebar -->

    <?php
        include '_partials/nav.view.php'
    ?>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">

        <?php
            include '_partials/header.view.php'
        ?>

        <main class="container-fluid">
            <?php
                require($physicalPath . 'router.php');
            ?>
        </main>

        <?php
            include "_partials/footer.view.php";
        ?>

    </div>
    <!-- /#page-content-wrapper -->

</div>
<!-- /#wrapper -->

<!-- Bootstrap core JavaScript -->
<script src="/saulius/01_20/templates/main/js/jquery.min.js"></script>
<script src="/saulius/01_20/templates/main/js/bootstrap.bundle.min.js"></script>

<!-- Menu Toggle Script -->
<script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
</script>
</body>
</html>
