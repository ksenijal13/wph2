<?php


namespace app\Controllers;
use app\Models\DB;
use app\Models\Menu;


class MenuController
{
    private $model;
    public function __construct(DB $db)
    {
        $this->model = new Menu($db);
        //$this->getMenu();
    }
    public function getMenu(){
        return $this->model->getMenu();
    }
}