<?php


namespace app\Models;
use app\Models\DB;

class Contact
{
    private $db;
    public function __construct(DB $db)
    {
        $this->db = $db;
    }
    public function getContact(){
        return $this->db->executeOneRowQuery("SELECT * FROM contact");
    }
}