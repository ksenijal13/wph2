<?php


namespace app\Controllers;
use app\Models\DB;
use app\Models\Collection;

class CollectionController
{
    private $model;

    public function __construct(DB $db)
    {
        $this->model = new Collection($db);
    }
    public function getAllCollections(){
        return $this->model->getAllCollections();
    }
    public function getValCollection(){
        return $this->model->getValCollection();
    }
    public function getSpCollection(){
        return $this->model->getSpCollection();
    }
}