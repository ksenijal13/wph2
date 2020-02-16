<?php


namespace app\Controllers;
use app\Models\Activity;

class ActivityController
{
    private $model;
    public function __construct()
    {
        $this->model = new Activity();
    }

    public function writeActivity($activity){
        return $this->model->writeActivity($activity);
    }
    public function loggedUser(){
        return $this->model->loggedUser();
    }
    public function loggedOutUser(){
        return $this->model->loggedOutUser();
    }
    public function loggedUsersNum(){
        return $this->model->loggedUsersNum();
    }
}