<div id="menu">
    <ul class="flex-element">
        <?php
        use app\Controllers\MenuController;
        global $db;
        $menuController = new MenuController($db);
        $menu = $menuController->getMenu();
        foreach($menu as $link):
            ?>
            <li>

                <?php if($link->link_text == "Home"){ ?>
                    <a href="index.php" id="<?=$link->link_text?>"> <?=$link->link_text?></a>
                <?php }
                else if($link->link_id == 8 || $link->link_id == 9){
                    ?> <a href="<?=$link->href?>" id="<?=$link->link_text?>"> <?=$link->link_text?></a>
               <?php }
                else { ?>
                    <a href="index.php?page=<?=$link->href?>" id="<?=$link->link_text?>"> <?=$link->link_text?></a>
                <?php } ?>
            </li>
        <?php
        endforeach;
        ?>
    </ul>
</div>
