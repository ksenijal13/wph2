<?php


namespace app\Controllers;
use app\Models\Category;
use app\Models\DB;

class CategoryController
{
    private $model;

    public function __construct(DB $db)
    {
        $this->model = new Category($db);
    }
    public function getAllCategories(){
        return $this->model->getAllCategories();
    }
}