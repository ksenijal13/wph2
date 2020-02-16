<div id="main-admin">
     <div id="all-socks-form">
         <?php include "app/views/partials/all-socks-form.php" ?>
         <div id="update_form_div">

         </div>
     </div>
    <div id="pagination-block">
        <ul class="flex-element">
            <?php
            $number_of_links = $sockController->countAllSocksWithoutCondition();
            for($i = 0; $i < $number_of_links; $i++):
                ?>
                <li>
                    <?php if($i == 0):?>
                    <a href="#"  id = "link-admin<?=$i?>" data-limit="<?=$i?>" class="socks_pagination-admin active"><?=$i+1?></a>
                    <?php else: ?>
                        <a href="#"  id = "link-admin<?=$i?>" data-limit="<?=$i?>" class="socks_pagination-admin"><?=$i+1?></a>
                    <?php endif; ?>
                </li>

            <?php endfor;
            ?>
        </ul>
    </div>
    <div id="insert_form_div">
        <?php include "app/views/partials/insert_form.php"; ?>
    </div>
    <div id="activity">
        <h4>Activity</h4>
        <p>Number of currently logged in users:
        <?php
        use app\Controllers\ActivityController;
             $activityController = new ActivityController();
             $number = $activityController->loggedUsersNum();
             echo $number;
             ?>
        </p>
    </div>
    <div id="errors">
    </div>
</div>