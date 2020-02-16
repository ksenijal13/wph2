<?php


namespace app\Models;
use app\Models\DB;

class Category
{
    private $db;
    public function __construct(DB $db)
    {
        $this->db = $db;
    }
    public function getAllCategories(){
        return $this->db->executeQuery("SELECT * FROM categories");
    }
}