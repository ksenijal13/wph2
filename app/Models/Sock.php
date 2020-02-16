<?php


namespace app\Models;
use app\Models\DB;
use app\Controllers\ActivityController;
class Sock
{
    private $conn;
    const PHOTO_OFFSET = 12;
    const ADMIN_PHOTO_OFFSET = 5;
    public function __construct(DB $db)
    {
        $this->conn = $db;

    }
    public function getAllSocks($limit, $paramS = 1){
        $query = "SELECT show_first, id, s.name as sock_name, si.image as big_image, small_image, si.sock_id as id_sock,  if(discount > 0, (price - (discount / 100 * price)), price) as  pricep, price,  discount 
                  FROM socks s INNER JOIN socks_info si 
                  ON s.sock_id = si.sock_id WHERE show_first is true";
        $part = "";
        $dataparam = [];
        $filter = "";
        $color = 0;
        $collection = 0;
           if (isset($paramS['searchValue'])) {
               if($paramS['searchValue'] != 1) {
                   $query .= "  AND s.name LIKE :param";
                   $part .= " AND s.name LIKE ?";
                   $paramS = $paramS['searchValue'];
                   $filter = "search";
                   $dataparam[] = "%" . $paramS . "%";
                   $countSocks = $this->countProducts($part, $dataparam);
               }
           }
           if(isset($paramS['collection'])){
               if ($paramS['collection'] != 0) {
                   $query .= " AND collection_id = :paramCollection ";
                   $part .= " AND collection_id = ?";
                   $paramCollection = $paramS['collection'];
                   $filter = "coll";
                   $collection = 1;
                   $dataparam[] = $paramCollection;
               }
           }
           if (isset($paramS['colorId'])) {
               if ($paramS['colorId'] != 0) {
                   $query .= " AND color_id = :paramColor ";
                   $part .= " AND color_id = ?";
                   $paramColor = $paramS['colorId'];
                   $filter = "color";
                   $color = 1;
                   $dataparam[] = $paramColor;
               }
           }
           if(isset($paramS['gender'])) {
               if($paramS['gender'] == "woman" || $paramS['gender'] == "men") {
                       $paramGender = $paramS['gender'];
                   if ($paramGender == "woman") {
                       $query .= " AND (category_id IN(2, 3))";
                       $part .= " AND (category_id IN(2, ?)) ";
                       $dataparam[] = 3;
                   } else {
                       $query .= " AND (category_id IN (1, 3)) ";
                       $part .= " AND (category_id IN (1, ?))";
                       $dataparam[] = 3;
                   }
              }
           }

        if(isset($paramS['sortPrice'])) {
            $part.= "";
                if($paramS['sortPrice'] == "price-asc"){
                    $query .= " ORDER BY pricep ASC ";
                }
                else {
                    $query .= " ORDER BY pricep DESC";
                }
        }
        $query .= " LIMIT :limit, :offset";
        if($part == ""){
            $countSocks = $this->countAllProducts() / self::PHOTO_OFFSET;
        }
        else {
            $countSocks = $this->countProducts($part, $dataparam);
        }

        try{
            $select = $this->conn->conn->prepare($query);
            $limit = ((int) $limit) * self::PHOTO_OFFSET;
            $select->bindParam(":limit", $limit, \PDO::PARAM_INT);
            $offset = self::PHOTO_OFFSET;
            $select->bindParam(":offset", $offset, \PDO::PARAM_INT);
                if ($filter == "search") {
                    $paramS = "%" . $paramS . "%";
                    $select->bindParam(":param", $paramS, \PDO::PARAM_STR);
                } if ($color) {
                    $select->bindParam(":paramColor", $paramColor, \PDO::PARAM_INT);
                } if($collection){
                    $select->bindParam(":paramCollection", $paramCollection, \PDO::PARAM_INT);
                }
            $select->execute();
                $photos = $select->fetchAll();
            $socks_count = [];
            $socks_count[] = $photos;
            $socks_count[] = $countSocks;
            return $socks_count;
        }
        catch(PDOException $e){
            return null;
        }
    }
    public function getOneSock($id){
        //this get basic mother  sock
        $array = $this->conn->executeQueryWithParams("SELECT * FROM socks_info WHERE sock_id = ?", [$id]);
        $data = $array[1];
        return $data->fetchAll();
    }
    public function getBigSockImage($id){
        $array = $this->conn->executeQueryWithParams("SELECT image  FROM socks_info WHERE id = ?", [$id]);
        $data = $array[1];
        return $data->fetch();
    }
    public function getAllSocksWithoutCondition($limit){
        $limit = ((int) $limit) * self::ADMIN_PHOTO_OFFSET;
        $offset = self::ADMIN_PHOTO_OFFSET;
        $query = "SELECT *, s.name as sock_name, id , si.image as sock_image, si.sock_id as id_sock, c.color_id as id_color, color_name, cat_id, cat_name, coll.collection_id as coll_id, collection_name, price, discount
                  FROM socks s LEFT OUTER JOIN socks_info si 
                  ON s.sock_id = si.sock_id  LEFT OUTER JOIN colors c ON c.color_id = si.color_id LEFT OUTER JOIN categories cat ON cat.cat_id = si.category_id LEFT OUTER JOIN collections coll ON coll.collection_id = si.collection_id WHERE id is not NULL LIMIT :limit, :offset";
        $select = $this->conn->conn->prepare($query);
        $select->bindParam(":limit", $limit, \PDO::PARAM_INT);
        $select->bindParam(":offset", $offset, \PDO::PARAM_INT);
        $select->execute();
        $rows = $select->rowCount();
        $socks = 0;
        //if($select->rowCount()== 1){
           // $socks = $select->fetch();
       // }
       //else {
           $socks = $select->fetchAll();
      // }
        return $socks;
    }
    public function countProducts($part, $dataparam){
        $query = "SELECT COUNT(*) as number FROM socks_info si INNER JOIN socks s ON s.sock_id = si.sock_id WHERE show_first is true ";
        $query .= $part;
        $result = $this->conn->executeOneRow($query, $dataparam);
        return $result->number / self::PHOTO_OFFSET;
    }
    public function countProductsInitials(){
        $query = "SELECT COUNT(*) as number FROM socks_info WHERE show_first is true ";
        $result = $this->conn->executeOneRowQuery($query);
        return $result->number / self::PHOTO_OFFSET;
    }
    public function countAllProducts(){
        $query = "SELECT COUNT(*) as number FROM socks_info WHERE show_first is true ";
        $result = $this->conn->executeOneRowQuery($query);
        return $result->number;
    }
    public function countSocksWithoutCondition(){
        $result =  $this->conn->executeOneRowQuery("SELECT COUNT(*) as number FROM socks_info");
        return $result->number / self::ADMIN_PHOTO_OFFSET;
    }
    public function deleteSock($id, $limit){
        $query = "DELETE  FROM socks_info WHERE id = ?";
        $array = $this->conn->executeQueryWithParams($query, [$id]);
        $code = $array[0];
        $data = self::getAllSocksWithoutCondition($limit);
        if($code < 300){
            $code = 204;
            $activityController = new ActivityController();
            $admin = $_SESSION['user']->username;
            $activity = $admin . " has deleted photo with id: " .$id;
            $activityController->writeActivity($activity);
        }else{
            $error = new Error($code);
            $error->writeError();
        }
        return $data;
        http_response_code($code);
    }
    public function getOneSockAllInfo($id){

        $query = "SELECT *, s.name as sock_name, id , si.image as sock_image, si.sock_id as id_sock, c.color_id as id_color, color_name, cat_id, cat_name, coll.collection_id as coll_id, collection_name, price, discount
                  FROM socks s LEFT OUTER JOIN socks_info si 
                  ON s.sock_id = si.sock_id  LEFT OUTER JOIN colors c ON c.color_id = si.color_id LEFT OUTER JOIN categories cat ON cat.cat_id = si.category_id LEFT OUTER JOIN collections coll ON coll.collection_id = si.collection_id WHERE id = ?";
        return $this->conn->executeOneRow($query, [$id]);
    }
    public function updateSock($request){
        if(isset($request["update_sock_btn"])){
            $id = $request["sock_id"];
            $mother_id = $request["mother_id"];
            $coll = $request["coll-list-update"];
            $cat = $request["cat-list-update"];
            $price = $request["sock_price"];
            $discount = $request["sock_discount"];
            $result = 0;
            if($coll != "0"){
                $query = "UPDATE socks_info SET collection_id = ? WHERE id = ?";
                $array = $this->conn->executeQueryWithParams($query, [$coll, $id]);
                $result = $array[0];
            }
           if($price != ""){
                $query = "UPDATE socks SET price = ? WHERE sock_id = ?";
                $array = $this->conn->executeQueryWithParams($query, [$price, $mother_id]);
                $result = $array[0];
            }
            if($discount != ""){
                $query = "UPDATE socks SET discount = ? WHERE sock_id = ?";
                $array = $this->conn->executeQueryWithParams($query, [$discount, $mother_id]);
                $result = $array[0];
            }
            if($cat != "0"){
                $query = "UPDATE socks_info SET category_id = ? WHERE id = ?";
                $array = $this->conn->executeQueryWithParams($query, [$cat, $id]);
                $result = $array[0];
            }

            if(!empty($_FILES['file']['name'])){
                $file_name = $_FILES["file"]["name"];
                $file_name = "mynew".$file_name;
                $tmp_name = $_FILES["file"]["tmp_name"];
                $size = $_FILES["file"]["size"];
                $type = $_FILES["file"]["type"];
                $error = $_FILES["file"]["error"];

                /* SMALLER ONE */
                list($width, $height) = getimagesize($tmp_name);
                $new_width = 120;
                $proc_change = $width / $new_width ;
                $new_height = $height * $proc_change;

                if($type == "image/jpeg" ) { $img = imagecreatefromjpeg($tmp_name); }
                else if( $type == "image/gif" ) { $img = imagecreatefromgif($tmp_name); }
                else if( $type == "image/png" ) { $img = imagecreatefrompng($tmp_name); }

                $empty_image = imagecreatetruecolor($new_width, $new_height);
                imagecopyresampled($empty_image, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                $new_image = $empty_image;

                $name = 'new'.$file_name;
                $path_new_image = 'app/assets/img/'.$name;

                switch($type){
                    case 'image/jpeg':
                        imagejpeg($new_image, $path_new_image, 75);
                        break;
                    case 'image/png':
                        imagepng($new_image, $path_new_image);
                        break;
                }
                $path_original_image = 'app/assets/img/'.$name;
                var_dump($tmp_name);
                if(move_uploaded_file($tmp_name, $path_original_image)){

                }
                /* THE END OF SMALLER IMAGE */
                $new_width_big = 300;
                $proc_change_big = $width / $new_width_big ;
               $new_height_big = $height * $proc_change_big;

                $empty_image_big = imagecreatetruecolor($new_width_big, $new_height_big);
                imagecopyresampled($empty_image_big, $img, 0, 0, 0, 0, $new_width_big, $new_height_big, $width, $height);
                $new_image_big = $empty_image_big;


                // UPLOAD OF THE NEW ONE
                $name_big = 'newbig'.$file_name;
                $path_new_image_big = 'app/assets/img/'.$name_big;

                switch($type){
                    case 'image/jpeg':
                        imagejpeg($new_image_big, $path_new_image_big, 75);
                        break;
                    case 'image/png':
                        imagepng($new_image_big, $path_new_image_big);
                        break;
                }

                $path_original_image_big = 'app/assets/img/'.$name_big;
                if(move_uploaded_file($tmp_name, $path_original_image_big)){

                }
                $query = "UPDATE socks_info SET image = ?, small_image = ? WHERE id = ?";
                $array = $this->conn->executeQueryWithParams($query, [$name_big, $name, $id]);
                $result = $array[0];
            }
            if($result == 200){
                $activityController = new ActivityController();
                $admin = $_SESSION['user']->username;
                $activity = $admin . " has updated photo with id: " .$id;
                $activityController->writeActivity($activity);
                header("Location: admin.php");
            }
        }
    }
    public function insertSock($request){
        if(isset($request["insert_sock_btn"])){
            $name = $request["insert-sock-name"];
            $coll = $request["insert-sock-coll"];
            $cat = $request["insert-sock-cat"];
            $price = $request["insert-sock-price"];
           $color = $request["insert-sock-color"];

           if($name != "" && $price !=""){
               $query = "INSERT INTO socks (name, price) VALUES(?, ?)";
               $result = $this->conn->insertQuery($query, [$name, $price]);
               if($result == 201){
                   $mother_id = $this->conn->conn->lastInsertId();
               }
               else{
                   $error = new Error($result);
                   $error->writeError();
               }
           }
           if($coll == "0"){
               $coll = null;
           }
            if(!empty($_FILES['insert-sock-file']['name'])){
                $file_name = $_FILES["insert-sock-file"]["name"];
                $file_name = "mynew".$file_name;
                $tmp_name = $_FILES["insert-sock-file"]["tmp_name"];
                $size = $_FILES["insert-sock-file"]["size"];
                $type = $_FILES["insert-sock-file"]["type"];
                $error = $_FILES["insert-sock-file"]["error"];

                /* SMALLER IMAGE */
                list($width, $height) = getimagesize($tmp_name);
                $new_width = 120;
                $proc_change = $width / $new_width ;
                $new_height = $height * $proc_change;

                if($type == "image/jpeg" ) { $img = imagecreatefromjpeg($tmp_name); }
                else if( $type == "image/gif" ) { $img = imagecreatefromgif($tmp_name); }
                else if( $type == "image/png" ) { $img = imagecreatefrompng($tmp_name); }

                $empty_image = imagecreatetruecolor($new_width, $new_height);
                imagecopyresampled($empty_image, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                $new_image = $empty_image;


                $name = 'new'.$file_name;

                $path_new_image = 'app/assets/img/'.$name;

                switch($type){
                    case 'image/jpeg':
                        imagejpeg($new_image, $path_new_image, 75);
                        break;
                    case 'image/png':
                        imagepng($new_image, $path_new_image);
                        break;
                }

                $path_original_image = 'app/assets/img/'.$name;
                if(move_uploaded_file($tmp_name, $path_original_image)){

                }
                /* the end of smaller */
                $new_width_big = 300;
                $proc_change_big = $width / $new_width_big ;
                $new_height_big = $height * $proc_change_big;

                $empty_image_big = imagecreatetruecolor($new_width_big, $new_height_big);
                imagecopyresampled($empty_image_big, $img, 0, 0, 0, 0, $new_width_big, $new_height_big, $width, $height);
                $new_image_big = $empty_image_big;

                // upload new one
                $name_big = 'newbig'.$file_name;
                $path_new_image_big = 'app/assets/img/'.$name_big;

                switch($type){
                    case 'image/jpeg':
                        imagejpeg($new_image_big, $path_new_image_big, 75);
                        break;
                    case 'image/png':
                        imagepng($new_image_big, $path_new_image_big);
                        break;
                }

                $path_original_image_big = 'app/assets/img/'.$name_big;
                var_dump($tmp_name);
                if(move_uploaded_file($tmp_name, $path_original_image_big)){

                }
            }
            $show_first = 1;
            $query = "INSERT INTO socks_info (sock_id, category_id, collection_id, image, small_image, color_id, show_first)
                      VALUES(?, ?, ?, ?, ?, ?, ?)";
            $result = $this->conn->insertQuery($query, [$mother_id, $cat, $coll, $name_big, $name, $color, $show_first]);
            if($result == 201){
                $activityController = new ActivityController();
                $admin = $_SESSION['user']->username;
                $activity = $admin . " has inserted new photo";
                $activityController->writeActivity($activity);
                header("Location: admin.php");
            }
        }
    }
}