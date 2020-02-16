<?php


namespace app\Models;
use app\Models\DB;

class Color
{
    private $db;
    public function __construct(DB $db)
    {
        $this->db = $db;
    }
    public function getAllColors(){
        return $this->db->executeQuery("SELECT * FROM colors");
    }
}