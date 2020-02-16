<form name="all_photos_info_form" id="all_photos_info_form">
    <table id="all_photos_table">
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Image</th>
            <th>Price</th>
            <th>Discount</th>
            <th>Category</th>
            <th>Collection</th>
            <th><i class="fa fa-edit"></i></th>
        </tr>
        <?php
        // GET ALL SOCKS FOR FORM
            use app\Controllers\SockController;
            use app\Controllers\CategoryController;
            global $db;
            $sockController = new SockController($db);
            $limit = isset($_GET['limit']) ? $_GET['limit'] : 0;
            $socks = $sockController->getAllSocksWithoutCondition($limit);
            $categoryController = new CategoryController($db);
            $categories = $categoryController->getAllCategories();
            foreach($socks as $sock): ?>
            <tr>
                <td><?=$sock->id?></td>
                <td><?=$sock->name?></td>
                <td class="td_img"><img src="app/assets/img/<?=$sock->sock_image?>" alt="<?=$sock->name?>"</td>
                <td><?=$sock->price?>&#36;</td>
                <td><?php  $discount = ($sock->discount != null) ? $sock->discount : 0?> <?=$discount?>%</td>
                <td><?=$sock->cat_name?></td>
                <td><?php $collection = ($sock->collection_name != null) ? $sock->collection_name : "none" ?><?=$collection?></td>
                <td>
                    <button data-id="<?=$sock->id?>" class="edit_btn update_btn" type="button">Update</button>
                    <button data-id="<?=$sock->id?>" class="edit_btn delete_btn" data-limit="<?=$limit?>" type="button">Delete</button>
                </td>
            </tr>
            <?php endforeach;
        ?>
    </table>
</form>
