<?php

namespace app\Controllers;
use app\Models\User;
use app\Models\DB;
header("Content-type: application/json");

class LoginController
{
    private $model;
    public function __construct(DB $db)
    {
        $this->model = new User($db);

    }
    public function login($request){
        if(isset($request['btnLogin'])) {
            $data_array = [];
            $errors_array = [];

            $username = $request['username_login'];
            $password = $request['password_login'];

            $username_reg = "/(?=.*[a-z])(?=.*[0-9])(?=.{8,})/";

            if (empty($username)) {
                $errors_array[] = "Username is a required field.";
            } else if (!preg_match($username_reg, $username)) {
                $errors_array[] = "Username must contain letters  and numbers.";
            }

            $password_reg = "/(?=.*[a-z])(?=.*[0-9])(?=.{8,})/";

            if (empty($password)) {
                $errors_array[] = "Password is a required field.";
            } else if (!preg_match($password_reg, $password)) {
                $errors_array[] = "Password must contain letters and numbers.";
            }
            if(count($errors_array) > 0){

                $code = 422;
                $data = $errors_array;
            }
            else {
                return $this->model->loginUser($username, $password);
            }
        }else {
            http_response_code(404);
        }

    }
}