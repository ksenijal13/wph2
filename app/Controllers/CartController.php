<?php


namespace app\Controllers;
use app\Models\DB;
use app\Models\Cart;


class CartController
{
    private $model;
    public function __construct(DB $db){
        $this->model = new Cart($db);
    }
    public function addToCart($request){
        return $this->model->addToCart($request);
    }
    public function getCartData(){
        return $this->model->getCartData();
    }
    public function deleteFromCart($request){
        return $this->model->deleteFromCart($request);
    }
    public function updateQuantity($request){
        return $this->model->updateQuantity($request);
    }
}