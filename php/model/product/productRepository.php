<?php
class Repository  
{
    private $_name;
    private $_price;
    private $_sku;
    private $_image;
    function __construct($request = null) {
      $productData = json_decode($request);
      $this->_name  =$productData->name;
      $this->_price =$productData->price;
      $this->_sku   =$productData->sku;
      $this->_image =$productData->image;
    }
    
    public function create($con){
        $query= $this->buildQuery();
        if(mysqli_query($con, $query)) {
            $message = "Product created Successfully.";
            $status = 200;			
        } else {
            $message = "Product creation failed.";
            $status = 401;			
        }
        $productResponse = array(
            'status' => $status,
            'status_message' => $message
        );
        header('Content-Type: application/json');
        echo json_encode($productResponse, JSON_PRETTY_PRINT);
    }

    public function getAll($con){
        $query = $this->buildGetAllQuery();
        
        $result = mysqli_query($con, $query);
        $response = array();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){ 
          array_push($response, array(
            "id" => $row["id"],
            "name" =>$row["name"],
            "price" => $row["price"],
            "sku" => $row["sku"],
            "image" => $row["image"]
          ));
        }
        header('Content-Type: application/json');
        echo json_encode($response,JSON_PRETTY_PRINT);
    }

    public function delete($con, $productId) {
      if($productId) {
        $deleteQuery = $this->buildDeleteQuery($productId);
            if( mysqli_query($con, $deleteQuery)) {
                $message = "Employee delete Successfully.";
                $status = 1;			
            } else {
                $message = "Employee delete failed.";
                $status = 0;			
            }		
        } else {
            $message = "Invalid request.";
            $status = 0;
        }
        $empResponse = array(
            'status' => $status,
            'status_message' => $message
        );
        header('Content-Type: application/json');
        echo json_encode($empResponse, JSON_PRETTY_PRINT);	
    }

    private function buildGetAllQuery(){
    return "SELECT * FROM {$_ENV['DATABASE']};";
    }

    private function buildDeleteQuery($id){
        return "DELETE FROM {$_ENV['DATABASE']}
                WHERE id = {$id} ORDER BY id DESC";	
    }

    private function buildQuery(){
    return "INSERT INTO 
    {$_ENV['DATABASE']}
    SET
      name=\"{$this->_name}\",
      price=\"{$this->_price}\",
      sku=\"{$this->_sku}\",
      image=\"{$this->_image}\" ";
    }
}
