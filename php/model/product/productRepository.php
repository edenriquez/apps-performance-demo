<?php
class Repository  
{
    private $_name;
    private $_price;
    private $_sku;
    private $_image;
    function __construct($request) {
      $productData = json_decode($request);
      $this->_name  =$productData->name;
      $this->_price =$productData->price;
      $this->_sku   =$productData->sku;
      $this->_image =$productData->image;
    }
    
    public function create($con){
        $query= $this->buildQuery();
        if(mysqli_query($con, $query)) {
            $messgae = "Product created Successfully.";
            $status = 200;			
        } else {
            $messgae = "Product creation failed.";
            $status = 401;			
        }
        $empResponse = array(
            'status' => $status,
            'status_message' => $messgae
        );
        header('Content-Type: application/json');
        echo json_encode($empResponse);
    }

    public function deleteEmployee($empId) {		
        if($empId) {			
            $empQuery = "
                DELETE FROM ".$this->empTable." 
                WHERE id = '".$empId."'	ORDER BY id DESC";	
            if( mysqli_query($this->dbConnect, $empQuery)) {
                $messgae = "Employee delete Successfully.";
                $status = 1;			
            } else {
                $messgae = "Employee delete failed.";
                $status = 0;			
            }		
        } else {
            $messgae = "Invalid request.";
            $status = 0;
        }
        $empResponse = array(
            'status' => $status,
            'status_message' => $messgae
        );
        header('Content-Type: application/json');
        echo json_encode($empResponse);	
    }
    
    function updateEmployee($empData){ 		
        if($empData["id"]) {
            $empName=$empData["empName"];
            $empAge=$empData["empAge"];
            $empSkills=$empData["empSkills"];
            $empAddress=$empData["empAddress"];		
            $empDesignation=$empData["empDesignation"];
            $empQuery="
                UPDATE ".$this->empTable." 
                SET name='".$empName."', age='".$empAge."', skills='".$empSkills."', address='".$empAddress."', designation='".$empDesignation."' 
                WHERE id = '".$empData["id"]."'";
                echo $empQuery;
            if( mysqli_query($this->dbConnect, $empQuery)) {
                $messgae = "Employee updated successfully.";
                $status = 1;			
            } else {
                $messgae = "Employee update failed.";
                $status = 0;			
            }
        } else {
            $messgae = "Invalid request.";
            $status = 0;
        }
        $empResponse = array(
            'status' => $status,
            'status_message' => $messgae
        );
        header('Content-Type: application/json');
        echo json_encode($empResponse);
    }
    
    public function getEmployee($empId) {		
        $sqlQuery = '';
        if($empId) {
            $sqlQuery = "WHERE id = '".$empId."'";
        }	
        $empQuery = "
            SELECT id, name, skills, address, age 
            FROM ".$this->empTable." $sqlQuery
            ORDER BY id DESC";	
        $resultData = mysqli_query($this->dbConnect, $empQuery);
        $empData = array();
        while( $empRecord = mysqli_fetch_assoc($resultData) ) {
            $empData[] = $empRecord;
        }
        header('Content-Type: application/json');
        echo json_encode($empData);	
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
