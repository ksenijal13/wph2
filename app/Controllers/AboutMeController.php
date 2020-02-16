<?php


namespace app\Controllers;
use app\Models\DB;
use app\Models\AboutMe;

class AboutMeController
{
    private $model;
    public function __construct(DB $db)
    {
        $this->model = new AboutMe($db);
    }
    public function getInfoAboutMe(){
        return $this->model->getInfoAboutMe();
    }
}