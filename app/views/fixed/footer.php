    <div class="flex-element" id="footer">
        <div id="f-logo" class="logo">
            <a href="index.php"><h1>&copy; miXenial Socks</h1></a>
        </div>
        <div id="f-soc">
              <ul class="flex-element">
                <a href="https://www.instagram.com"><li class="fa fa-instagram"></li></a>
                <a href="https://www.facebook.com/"><li class="fa fa-facebook"></li></a>
                <a href="https://www.snapchat.com/l/en-gb/"><li class="fa fa-snapchat"></li></a>
                <a href="https://twitter.com/"><li class="fa fa-twitter"></li></a>
              </ul>
              <ul class="flex-element" id="contact">
                  <?php
                  use app\Controllers\ContactController;
                  global $db;
                  $contactController = new ContactController($db);
                  $contact = $contactController->getContact(); ?>
                  <li>
                      Phone: <?=$contact->phone?>
                  </li>
                  <li>
                      Email: <?=$contact->email?>
                  </li>
                  <li>
                      Address: <?=$contact->address?>
                  </li>
              </ul>
        </div>
        <div id="about-me" class="flex-element">
            <!--dodati u bazu o meni-->
            <div id="image-me">
               <?php
               use app\Controllers\AboutMeController;
               global $db;
               $about_me_controller = new AboutMeController($db);
               $me_info = $about_me_controller->getInfoAboutMe();
               ?>
                <img src="app/assets/img/<?=$me_info->image?>" alt = "<?=$me_info->alt?>"/>

            </div>
            <p><?=$me_info->biography?>
                Go to:
            <a href="app/data/documentation.pdf"> Documentation.</a>
             <a href="#">GitHub.</a>
        </p>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="app/assets/js/main.js"></script>
</div>
</html>