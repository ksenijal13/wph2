<?php
namespace app\Models;
use app\Models\DB;
use app\Models\Error;
use app\Controllers\ActivityController;
header("Content-type: application/json");

class User
{
    private $db;
    private $code;
    private $result = null;
    private $data;
    public function __construct(DB $db)
    {
        $this->db = $db;
    }
    public function loginUser($username, $password){
        if(isset($_SESSION['error'])){
            unset($_SESSION['error']);
        }
        if(isset($_SESSION['success'])){
            unset($_SESSION['success']);
        }
        $data_array = $this->db->executeQueryWithParams("SELECT * FROM users WHERE username = ? AND password = ?", [$username, md5($password)]);
        if($data_array[0] == 200) {

            $prepare = $data_array[1];

            if($prepare->rowCount() == 1) {
                $this->code = 201;
                $user = $prepare->fetch();
                $_SESSION['user'] = $user;

                if ($_SESSION['user']->role_id == 1) {
                    $this->data = "admin";
                    $this->code = 200;

                } else {
                    $this->code = 200;
                    $this->data = "user";
                }
            }else {
                if ($prepare->rowCount() == 0) {
                    $this->code = 403;
                    $_SESSION['error'] = "You are not registered.";
                    header("Location: index.php");
                }
            }
        }
        else {
            $this->code = $data_array[0];
        }
        if($this->code > 400){
           $error = new Error($this->code);
           $error->writeError($this->code);
        }
        if($this->code != 403) {
            http_response_code($this->code);
        }
        if($this->data == "user"){
            $activityController = new ActivityController();
            $activityController->loggedUser();
            header("Location: index.php");
        }
        if($this->data == "admin"){
            $_SESSION['admin'] = "admin";
            $activityController = new ActivityController();
            $activityController->loggedUser();
            header("Location: admin.php");
        }

    }

    public function register($first_name, $last_name, $username, $password, $email){
        $code = 200;
        $prepare = $this->db->conn->prepare("SELECT * FROM users WHERE username = ? or email = ?");
        $prepare->execute([$username, $email]);
        if($prepare->rowCount() >= 1){
            $_SESSION['error'] = "User with these data already exists.";
            header("Location:index.php");
        }
        $query = "INSERT INTO users
        (first_name, last_name, username, password, role_id, email)
        VALUES(?, ?, ?, ?, ?, ?)";

        $role_id = 2;
        $prepare_query = $this->db->conn->prepare($query);
       try {
           $code = $prepare_query->execute([$first_name, $last_name, $username, $password, $role_id, $email]) ? 201 : 500;
       }
        catch(PDOException $e){
            $code = 409;
        }
        if($code == 201){
            $_SESSION['success'] = "You are registered now. Please log in.";
            header("Location:index.php");
        }
        return $code;

    }

}