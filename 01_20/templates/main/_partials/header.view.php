<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
    <button class="btn btn-primary" id="menu-toggle">Slėpti meniu</button>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
            <?php foreach($nav['header'] as $href => $title):?>
                <?php if($href != "veiksmai"):?>
                    <li class="nav-item active">
                        <a class="nav-link" href="?page=<?=$href;?>"><?=$title;?><span class="sr-only">(current)</span></a>
                    </li>
                <?php else:?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown">
                            Veiksmai
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <?php foreach($nav['header'][$href] as $hrefint => $titleint):?>
                                <a class="dropdown-item" href="?page=<?=$hrefint;?>"><?=$titleint;?></a>
                            <?php endforeach;?>
                        </div>
                    </li>
                <?php endif;?>
            <?php endforeach;?>
        </ul>
    </div>
</nav>