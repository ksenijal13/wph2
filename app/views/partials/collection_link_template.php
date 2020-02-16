
<div class="collection-link-div"  id="<?=$cat->cat_name?>-coll">
    <a href="index.php?page=socks"><img src="app/assets/img/<?=$cat->image?>" alt="<?=$cat->cat_name?>"/>
    <div class="collection-shop-now">
        <h4>
           <?php if($cat->cat_id == 1){
               echo "No boring socks";
           }
           else {
               echo "Brightly colored socks";
           }?>
        </h4>
        <span class="shop-btn">Shop now</span>
    </div>
    </a>
</div>
