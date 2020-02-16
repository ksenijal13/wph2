<?php


namespace app\Controllers;


class Controller
{
    protected function view($fileName){
        include "app/views/fixed/head.php";
        if($fileName == "admin"){
            include "app/views/fixed/admin-header.php";
        }else {
            include "app/views/fixed/header.php";
        }
        include "app/views/pages/$fileName.php";
        include "app/views/fixed/footer.php";
    }
}