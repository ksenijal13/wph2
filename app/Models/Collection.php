<?php


namespace app\Models;
use app\Models\DB;

class Collection
{
    private $db;
    public function __construct(DB $db)
    {
        $this->db = $db;
    }
    public function getAllCollections(){
        return $this->db->executeQuery("SELECT * FROM collections");
    }
    public function getValCollection(){
        return $this->db->executeOneRowQuery("SELECT * FROM collections WHERE collection_id = 1");
    }
    public function getSpCollection(){
        return $this->db->executeOneRowQuery("SELECT * FROM collections WHERE collection_id = 2");
    }
}