<?php

namespace app\Controllers;
use app\Models\DB;
use app\Models\User;
use app\Models\Error;

class RegisterController
{
    private $model;
    private $code = 404;
    private $data = null;
    public function __construct(DB $db)
    {
        $this->model = new User($db);
    }
    public function register($request)
    {
        if(isset($request['btnSignup'])){
            if(isset($_SESSION['error'])){
                unset($_SESSION['error']);
            }
            $data_array = [];
            $errors_array = [];

            $first_name = $request['first_name'];
            $first_name_reg = "/^[A-Z][a-z]{2,13}(\s[A-Z][a-z]{2,13})*$/";

            if(empty($first_name)){
                $errors_array[] = "First name is a required field.";
            }
            else if(!preg_match($first_name_reg, $first_name)){
                $errors_array[] = "First name must contain only letters and must star with upperkey.";
            }

            $last_name = $request['last_name'];
            $last_name_reg = "/^[A-Z][a-žćčžš]{2,13}(\s[A-Z][a-žćčžš]{2,13})*$/";

            if(empty($last_name)){
                $errors_array[] = "Last name is a required field.";
            }
            else if(!preg_match($last_name_reg, $last_name)){
                $errors_array[] = "Last name must contain only letters and must star with upperkey.";
            }

            $username = $request['username_signup'];
            $username_reg = "/(?=.*[a-z])(?=.*[0-9])(?=.{8,})/";

            if(empty($username)){
                $errors_array[] = "Username is a required field.";
            }
            else if(!preg_match($username_reg, $username)){
                $errors_array[] = "Username must contain letters  and numbers.";
            }

            $password = $request['password_signup'];
            $password_reg = "/(?=.*[a-z])(?=.*[0-9])(?=.{8,})/";

            if(empty($password)){
                $errors_array[] = "Password is a required field.";
            }
            else if(!preg_match($password_reg, $password)){
                $errors_array[] = "Password must contain letters and numbers.";
            }

            $repeat_password = $request['repeat_password'];

            if(empty($repeat_password)){
                $errors_array[] = "Repeat password is a required field.";
            }
            else if($repeat_password != $password){
                $errors_array[] = "Repeat password field does not match with your password.";
            }

            $email = $request['user_email'];

            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = "Email is not in correct form.";
            }

            if(count($errors_array) > 0){

                $code = 422;
            }
            else{
                return $this->model->register($first_name, $last_name, $username, md5($password), $email);
            }
        }
        if($code == 409){
            $_SESSION['error'] = "User with these data already exists.";
            header("Location:index.php");
        }
        if($code > 400){
            $error = new Error($code);
            $error->writeError();
        }
        http_response_code($code);
    }
}