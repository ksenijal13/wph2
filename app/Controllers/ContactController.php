<?php


namespace app\Controllers;
use app\Models\DB;
use app\Models\Contact;

class ContactController
{
    private $model;
    public function __construct(DB $db)
    {
        $this->model = new Contact($db);
    }
    public function getContact(){
        return $this->model->getContact();
    }
}