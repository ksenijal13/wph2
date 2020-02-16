
    <div id="colors" class="sidebar-element">
        <h3>Colors</h3>
        <ul id="colors-list" class="flex-element">
            <!-- colors from database-->
            <?php
                use app\Controllers\ColorController;
                $colorController = new ColorController($db);
                $colors = $colorController->getAllColors();
                foreach($colors as $color):
            ?>
                    <a href="#" data-id="<?=$color->color_id?>" id="<?=$color->color_name?>" class="color-link"><li></li></a>

            <?php endforeach; ?>
                <a href="#" class="erasercl" id="color-eraser"><span class="fa fa-eraser" aria-hidden="true"></span></a>
        </ul>
    </div>
    <div id="women-men" class="sidebar-element border-top-element">
        <h3>Gender</h3>
        <ul id="gender-list" class="flex-element">
            <li><a href="#" class = "gender-link" data-gender="woman"><span class="fa fa-venus "></span></a></li>
            <li><a href="#" class = "gender-link" data-gender="men"><span class="fa fa-mars"></span></a></li>
            <a href="#" class="erasercl" id="gender-eraser"><span class="fa fa-eraser" aria-hidden="true"></span></a>
        </ul>
        <p>90% of socks are for both gender.</p>

    </div>
    <div id="collections" class="sidebar-element border-top-element">
        <h3>Collections</h3>
        <ul id="collection-list">
        <?php
            use app\Controllers\CollectionController;
            $collectionController = new CollectionController($db);
            $collections = $collectionController->getAllCollections();
            foreach($collections as $collection):
                ?>
                <li>
                    <a href="#" class="collection-link" data-id="<?=$collection->collection_id?>"><?=$collection->collection_name?></a>
                </li>
                <?php
            endforeach;
        ?>
                <li>
                    <a href="#" class="erasercl" id="coll-eraser"><span class="fa fa-eraser" aria-hidden="true"></span></a>
                </li>
        </ul>
    </div>

