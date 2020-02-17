<?php


namespace app\Models;


class DB
{
    private $server;
    private $database;
    private $username;
    private $password;

    public $conn;

    public function __construct($server, $database, $username, $password){
        $this->server = $server;
        $this->database = $database;
        $this->username = $username;
        $this->password = $password;

        $this->connect();
    }

    private function connect(){
        $this->conn = new \PDO("mysql:host={$this->server};dbname={$this->database};charset=utf8", $this->username, $this->password);
        $this->conn->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
        $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function executeQuery($query){
        return $this->conn->query($query)->fetchAll();
    }
    public function executeOneRowQuery($query){
        return $this->conn->query($query)->fetch();
    }
    public function executeOneRow(string $query, Array $params){
        $prepare = $this->conn->prepare($query);
        $prepare->execute($params);
        return $prepare->fetch();
    }
    public function executeQueryWithParams($query, $params){
        $code = 200;
        $result = 0;
        $data_array = [];
        $prepare = $this->conn->prepare($query);
        try {
            $result = $prepare->execute($params);
            if(!$result) {
                $code = 402;
            }
        }catch(\PDOException $e){
            $code = 500;
        }
        $data_array[] = $code;
        $data_array[] = $prepare;
        return $data_array;

    }
    public function insertQuery(string $query, Array $params){
        try {
            $prepare_query = $this->conn->prepare($query);
            $result = $prepare_query->execute($params);
            if($result){
                $result = 201;
            }
            return $result;
        }catch(\PDOException $e){
            return 409;
        }
    }

}
