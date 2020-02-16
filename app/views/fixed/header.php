<body>
    <div id="wrapper">
        <div id="header">
        <div id="user-error">
            <?php if(isset($_SESSION['error'])){ ?>
                <p><?=$_SESSION['error']?></p>
                <a href="#" id="close-error">Ok.</a>
           <?php } ?>
        </div>
         <div id="success">
             <?php if(isset($_SESSION['success'])){ ?>
                 <p><?=$_SESSION['success']?></p>
                 <a href="#" id="close-success">Ok.</a>
             <?php } ?>
         </div>
            <div id="top-message" class="flex-element">

                <div id="p-div"><p>Free shipping on orders over €35</p></div>
                <div id="login" class="flex-element">
                    <?php if(isset($_SESSION['user'])){ ?>
                        <p> <?= $_SESSION['user']->username; ?></p>
                        <a id="sign-out" href="index.php?page=signout"><li class="fa fa-sign-out" id="sign-out" aria-hidden="true"></li></a>
                    <?php  }
                    else{ ?>
                    <a href="#" id="user-fa">
                        <span class="fa fa-user" aria-hidden="true"></span>
                    </a>
                    <?php } ?>
                </div>
                <div id="registration-form" class="flex-element">

                    <?php
                        include("app/views/partials/login.php");
                        include("app/views/partials/sign_up.php");

                    ?>
                    <div id="errors_div">
                    </div>
                    <a href="#" id="btn-hide-reg-form"><li class="fa fa-window-close"></li></a>

                </div>
            </div>
            <div id="header-content" class="flex-element">
                <div class="logo"><a href="index.php"><h1>miXenial Socks</h1></a></div>

                <div id="search-socks" class="flex-element">
                    <div id="shopping-cart" class="flex-element">
                        <?php if(isset($_SESSION['user'])):?>
                        <a href="#" id="your-cart-link">
                            <span class="fa fa-shopping-cart"></span>
                            <p>Cart</p>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>


            </div>
            <div id="menu-d" class="flex-element">
                <?php include "app/views/fixed/menu.php"; ?>
            </div>

        </div>