<?php
session_start();
require_once "app/config/autoload.php";
require_once "app/config/database.php";
use app\Models\DB;
use app\Controllers\PageController;
use app\Controllers\LoginController;
use app\Controllers\RegisterController;
use app\Controllers\SockController;
use app\Controllers\CategoryController;
use app\Controllers\CollectionController;
use app\Controllers\ActivityController;
use app\Models\Error;
$db = new DB(SERVER, DATABASE, USERNAME, PASSWORD);

$pageController = new PageController($db);
if(isset($_SESSION['admin'])) {
    if (isset($_GET['page'])) {
        switch ($_GET['page']) {
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
            case "update":
                $sockController = new SockController($db);
                $sockController->updateSock($_POST);
                break;
            case "insert":
                $sockController = new SockController($db);
                $sockController->insertSock($_POST);
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
            case "signout":
                unset($_SESSION['user']);
                if (isset($_SESSSION['admin'])) {
                    unset($_SESSION['admin']);
                }
                $activityController = new ActivityController();
                $activityController->loggedOutUser();
                header("Location: index.php");
                break;
            case "onesock":
                $sockController = new SockController($db);
                $id = $_GET['id'];
                $socks = $sockController->getOneSockAllInfo($id);
                echo json_encode($socks);
                break;
        }
    } else {
        $pageController->admin();
    }
}else{
    http_response_code(404);
    $error = new Error(404);
    $error->writeError();
}