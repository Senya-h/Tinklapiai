<div class="bg-light border-right" id="sidebar-wrapper">
    <div class="sidebar-heading">Filmų duomenų bazė</div>
    <div class="list-group list-group-flush">
        <?php foreach($nav["sidebar"] as $href => $value):?>
            <a href="?page=<?=$href;?>" class="list-group-item list-group-item-action bg-light"><?=$value;?></a>
        <?php endforeach;?>
    </div>
</div>