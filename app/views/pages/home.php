<div id="main" class="flex-element">
    <div id="first-cover">
        <?php
        use app\Controllers\CollectionController;
        global $db;
        $collectionController = new CollectionController($db);
        $sp = $collectionController->getSpCollection();
        ?>
        <a href="index.php?page=socks"><img src="app/assets/img/<?=$sp->image?>" alt="Cover1"/>
            <div class="collection-shop-now " id="spring-coll">
                <h4>Put some color in your step</h4>
                <span class="shop-btn">Shop now</span>
            </div>
        </a>
    </div>
</div>
<div class="flex-element" id="socks">
</div>
<div id="collections-home" class="flex-element">
    <?php
        use app\Controllers\CategoryController;
        global $db;
        $categoryController = new CategoryController($db);
        $categories = $categoryController->getAllCategories();
        foreach($categories as $cat):
            if($cat->cat_name != "Universal") {
                include "app/views/partials/collection_link_template.php";
            }
        endforeach;
    ?>
</div>
<?php
    $v = $collectionController->getValCollection();
    include "app/views/partials/valentine-home-cover.php";
?>
<div id="your-cart" class="flex-element">

</div>
