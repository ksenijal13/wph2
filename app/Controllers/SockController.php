<?php


namespace app\Controllers;
use app\Models\DB;
use app\Models\Sock;


class SockController
{
    private $model;
    public function __construct(DB $db)
    {
        $this->model = new Sock($db);
    }
    public function getAllSocks($limit, $paramS = 1){
        if(isset($paramS['limit'])){
            $limit = $paramS['limit'];
        }
        return $this->model->getAllSocks($limit, $paramS);
    }
    public function getOneSock($id){
        if(isset($id['id'])){
            $id = $id['id'];
        }
        return $this->model->getOneSock($id);
    }
    public function getAllSocksWithoutCondition($limit){
        return $this->model->getAllSocksWithoutCondition($limit);
    }
    public function getBigSockImage($request){
        $id = $request['id'];
        return $this->model->getBigSockImage($id);
    }
    public function  countProducts(){
        return $this->model->countProducts();
    }
    public function  countProductsInitials(){
        return $this->model->countProductsInitials();
    }
    public function countAllProducts(){
        return $this->model->countAllProducts();
    }
    public function countAllSocksWithoutCondition(){
        return $this->model->countSocksWithoutCondition();
    }
    public function deleteSock($id, $limit){
        return $this->model->deleteSock($id, $limit);
    }
    public function getOneSockAllInfo($id){
        return $this->model->getOneSockAllInfo($id);
    }
    public function updateSock($request){
        return $this->model->updateSock($request);
    }
    public function insertSock($request){
        return $this->model->insertSock($request);
    }
}