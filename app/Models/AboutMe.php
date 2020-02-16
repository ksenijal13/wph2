<?php


namespace app\Models;
use app\Models\DB;

class AboutMe
{
    private $conn;
    public function __construct(DB $db)
    {
        $this->conn = $db;
    }
    public function getInfoAboutMe(){
        return $this->conn->executeOneRowQuery("SELECT image, biography, alt FROM about_me");
    }
}