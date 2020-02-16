<?php


namespace app\Controllers;
use app\Models\DB;
use app\Models\Color;

class ColorController
{
    private $model;
    public function __construct(DB $db)
    {
        $this->model = new Color($db);
    }
    public function getAllColors()
    {
        return $this->model->getAllColors();
    }
}