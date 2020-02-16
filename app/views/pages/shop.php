<div id="main-shop" class="flex-element">
    <!-- sidebar -->
    <div id="sidebar" class="flex-element">
         <?php include "app/views/partials/sidebar.php"; ?>
    </div>
    <div id="socks-and-sort">
        <div id="sort-search" class="flex-element">
            <div class="sort-element" id="search-element">
                <a href="#"><i class="fa fa-search" aria-hidden="true"></i></a>
                <input type="search" id="shop-search-socks" name="shop-search-socks"/>
            </div>
            <div id="count-products">
                <p id="count-paragraph">
                    <?php
                    use app\Controllers\SockController;
                    $sockController = new SockController($db);
                    $number_of_products = $sockController->countAllProducts();
                    echo $number_of_products;
                    ?>
                    products
                </p>
            </div>
            <div id="sort-by-products">
                <?php
                $sort_array = [
                    "0" => "sort by",
                    "price-asc" => "price, low to high",
                    "price-desc" => "price, high to low",
                ];
                ?>
                <select id="select-price">
                    <?php foreach($sort_array as $key => $value):
                        if($key == "0"):
                        ?>
                             <option disabled class="option-price" value="<?=$key?>"><?=$value?></option>
                        <?php else:
                        ?>
                        <option class="option-price" value="<?=$key?>"><?=$value?></option>
                    <?php endif; endforeach; ?>
                </select>
                <a href="#" class="erasercl" id="sort-eraser"><span class="fa fa-eraser" aria-hidden="true"></span></a>
            </div>
        </div>
        <div id="socks" class="flex-element">
            <?php
            $sockController = new SockController($db);
            $limit = isset($_GET['limit']) ? $_GET['limit'] : 0;
            $socks = $sockController->getAllSocks($limit);
            $socks = $socks[0];
            foreach($socks as $sock):
                if($sock->show_first):
                    include "app/views/partials/sock.php";
            endif;
            endforeach;
            ?>
        </div>
        <div id="pagination-block">
            <ul class="flex-element">
            <?php
                $number_of_links = $sockController->countProductsInitials();
                for($i = 0; $i < $number_of_links; $i++):
                    ?>
                    <li>
                        <a href="#"  id = "link<?=$i?>" data-limit="<?=$i?>" class="socks_pagination"><?=$i+1?></a>
                    </li>

                <?php endfor;
            ?>
            </ul>
        </div>

    </div>
</div>
<div id="cart-check-socks" class="flex-element">
</div>
<div id="your-cart" class="flex-element">

</div>