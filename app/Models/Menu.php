<?php


namespace app\Models;
use app\Models\DB;

class Menu
{
    private $db;
    public function __construct(DB $db){
        $this->db = $db;
    }
    public function getMenu(){
        return $this->db->executeQuery("SELECT * FROM menu  WHERE active is TRUE ORDER BY link_order");
    }
}