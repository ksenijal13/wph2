<div class="sock" data-id="">
    <div class="sock-wrapper" data-mainimage="<?=$sock->id?>">
        <img src="app/assets/img/<?=$sock->big_image?>" alt=""/>
    </div>
    <div class="small-pictures flex-element">
        <?php

        $id = $sock->id_sock;

        $small_pictures = $sockController->getOneSock($id);

        foreach($small_pictures as $small):

            ?>
            <div class="image-circle">
                <a href="#" data-id="<?=$small->id?>" id="sock<?=$small->id?>" class="small-image-link"><img src="app/assets/img/<?=$small->small_image?>" alt=""/></a>
            </div>
        <?php  endforeach;
        ?>
    </div>
    <h3><?=$sock->sock_name?></h3>
    <p>
        <?php
            if($sock->discount > 0){
                $price = $sock->price - ($sock->discount / 100 * $sock->price); ?>
                <p> <?=round($price) ?> <i id="old-price"><?=round($sock->price)?></i>

          <?php  }else{
        ?>
        <?=round($sock->price)?>&#36; <?php } ?>

    </p>
    <?php if(isset($_SESSION['user'])):?>
    <span class="span-cart"><i class="fa fa-shopping-cart"></i><a href="#" data-mother="<?=$sock->id_sock?>" class="add-to-cart">Add to Cart</a></span>
    <?php endif; ?>
</div>
