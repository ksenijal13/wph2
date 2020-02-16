<?php


namespace app\Controllers;



class PageController extends Controller
{
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }
    public function home(){
        $this->view("home");
    }
    public function shop(){
        $this->view("shop");
    }
    public function admin(){
        $this->view("admin");
    }
}