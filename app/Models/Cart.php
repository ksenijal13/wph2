<?php


namespace app\Models;
use app\Models\DB;

class Cart
{
    private $db;
    private $result;
    public function __construct(DB $db)
    {
        $this->db = $db;
    }
    public function addToCart($request){
        if(isset($request['socksArray'])){
            $socks_array = $request['socksArray'];
            $user_id = $_SESSION['user']->user_id;
            $quantity = 1;
            $query = "INSERT INTO cart(user_id, sock_id, quantity) VALUES(?, ?, ?)";
            foreach($socks_array as $sock_id):
                $is_in_cart = $this->db->executeQueryWithParams("SELECT * FROM cart WHERE user_id = ? && sock_id = ?", [$user_id, $sock_id]);
                if($is_in_cart[1]->rowCount() == 0) {
                    $result = $this->db->insertQuery($query, [$user_id, $sock_id, $quantity]);
                }
             endforeach;
             if($result > 400){
                 $error = new Error($result);
                 $error->writeError();
             }
        }
        http_response_code($result);
        return;
    }
    public function getCartData(){
        $id = $_SESSION['user']->user_id;
        $query = "SELECT *, c.id as cart_id FROM cart c INNER JOIN socks_info si ON c.sock_id = si.id INNER JOIN socks s ON s.sock_id = si.sock_id WHERE user_id = ?";
        $array =  $this->db->executeQueryWithParams($query, [$id]);
        $code = $array[0];
        $data = $array[1];
            $data = $data->fetchAll();
        if($code > 400){
            $error = new Error($code);
            $error->writeError();
        }
        return $data;
        http_response_code($code);
    }
    public function deleteFromCart($request){
        if(isset($request['id'])){
            $id = $request['id'];
            $user_id = $_SESSION['user']->user_id;
            $query = "DELETE  FROM cart WHERE id = ? AND user_id = ?";
            $array = $this->db->executeQueryWithParams($query, [$id, $user_id]);
            $code = $array[0];
            $data = self::getCartData();
            if($code < 300){
                $code = 204;
            }else{
                $error = new Error($code);
                $error->writeError();
            }
            return $data;
            http_response_code($code);

        }
    }
    public function updateQuantity($request){
        if(isset($request['id'])){
            $id = $request['id'];
            $user_id = $_SESSION['user']->user_id;
            $quantity = $request['quantity'];
            $query = "UPDATE cart SET quantity = ? WHERE id = ? AND user_id = ?";
            $array = $this->db->executeQueryWithParams($query, [$quantity, $id, $user_id]);
            $code = $array[0];
            $data = self::getCartData();
            if($code < 300){
                $code = 204;
            }else{
                $error = new Error($code);
                $error->writeError();
            }
            return $data;
            http_response_code($code);

        }
    }
}