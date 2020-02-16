<div id="header-admin" class="flex-element">
    <div id="logo-admin">
        <a href="index.php"><h1>miXenial Socks</h1></a>
    </div>
    <div id="admin-username">
        <p>
           <?= $_SESSION['user']->username ?>
        </p>
            <a id="sign-out" href="index.php?page=signout"><li class="fa fa-sign-out" id="sign-out" aria-hidden="true"></li></a>
    </div>
</div>

