<?php
session_start();
require_once "app/config/autoload.php";
require_once "app/config/database.php";
use app\Models\DB;
use app\Controllers\PageController;
use app\Controllers\LoginController;
use app\Controllers\RegisterController;
use app\Controllers\SockController;
use app\Controllers\CartController;
use app\Controllers\CategoryController;
use app\Controllers\CollectionController;
use app\Controllers\ActivityController;
use app\Models\Error;
$db = new DB(SERVER, DATABASE, USERNAME, PASSWORD);

$pageController = new PageController($db);

if(isset($_GET['page'])){
    switch($_GET['page']){
        case "admin":
            if(isset($_SESSION['admin'])) {
                $pageController->admin();
            }else{
                http_response_code(404);
                $error = new Error(404);
                $error->writeError();
            }
            break;
        case "login";
            header("Content-type: application/json");
            $loginController = new LoginController($db);
            echo $loginController->login($_POST);
            break;
        case "signout":
            unset($_SESSION['user']);
            if(isset($_SESSion['admin'])){
                unset($_SESSION['admin']);
            }
            $activityController = new ActivityController();
            $activityController->loggedOutUser();
            header("Location: index.php");
            break;
        case "register":
            header("Content-type: application/json");
            $registerController = new RegisterController($db);
            echo $registerController->register($_POST);
            break;
        case "checkuser":
            $user = 0;
            if(isset($_SESSION['user'])){
                $user = 1;
            }
            echo $user;
            break;
        case "socks":
            $pageController->shop();
            break;
        case "bigsock":
            $sockController = new SockController($db);
            $image = $sockController->getBigSockImage($_POST);
            echo json_encode($image);
            break;
        case "fcolor":
        case "limit":
            header("Content-type: application/json");
            $sockController = new SockController($db);
            $socks = $sockController->getAllSocks(0, $_POST);
            echo json_encode($socks);
            break;
        case "mothersock":
            $sockController = new SockController($db);
            $socks = $sockController->getOneSock($_GET);
            echo json_encode($socks);
            break;
        case "limitadmin":
            $sockController = new SockController($db);
            $limit = $_POST['limit'];
            $socks = $sockController->getAllSocksWithoutCondition($limit);
            echo json_encode($socks);
            break;
        case "delete":
            $sockController = new SockController($db);
            $id = $_GET['id'];
           $limit = $_GET['limit'];
            $socks = $sockController->deleteSock($id, $limit);
            echo json_encode($socks);
            break;
        case "search":
            $sockController = new SockController($db);
            $limit = 0;
            $socks = $sockController->getAllSocks($limit, $_POST);
            echo json_encode($socks);
            break;
        case "cart":
            $cartController = new CartController($db);
            $add = $cartController->addToCart($_POST);
            break;
        case "yourcart":
            $cartController = new CartController($db);
            $cart = $cartController->getCartData();
            echo json_encode($cart);
            break;
        case "deletecart":
            $cartController = new CartController($db);
            $cart = $cartController->deleteFromCart($_GET);
            echo json_encode($cart);
            break;
        case "updatecart":
            $cartController = new CartController($db);
            $cart = $cartController->updateQuantity($_GET);
            echo json_encode($cart);
            break;
        case "onesock":
            $sockController = new SockController($db);
            $id = $_GET['id'];
            $socks = $sockController->getOneSockAllInfo($id);
            echo json_encode($socks);
            break;
        case "categories":
            $categoryController = new CategoryController($db);
            $categories = $categoryController->getAllCategories();
            echo json_encode($categories);
            break;
        case "collections":
            $collectionController = new CollectionController($db);
            $collections = $collectionController->getAllCollections();
            echo json_encode($collections);
            break;
        case "update":
            $sockController = new SockController($db);
            $sockController->updateSock($_POST);
            break;
        case "insert":
            $sockController = new SockController($db);
            $sockController->insertSock($_POST);
            break;
    }
} else {
    $pageController->home();

}
