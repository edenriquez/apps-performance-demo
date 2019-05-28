<?php
Class Connection{
	private $_servername;
	private $_username;
	private $_password;
	private $_dbname;
  private $_conn;

  function __construct() {
    $this->_dbname      = $_ENV["DATABASE"];
    $this->_servername  = $_ENV['DB_IP'];
    $this->_username    = $_ENV["DB_USERNAME"];
    $this->_password    = $_ENV["DB_PASSWORD"];
  }

	function connect() {
    $con = mysqli_connect(
      $this->_servername,
      $this->_username,
      $this->_password) or die(
        "Connection failed: " . mysqli_connect_error()
      );
      
      if ($this->connectionError($con)){
        die("Connection failed: " . $con->connect_error);
        exit();
      }
    $this->conn = $con;
    $this->initializeDatabase();
    $this->initializeTable();
		return $this->conn;
  }

  // HELPERS
  private function initializeDatabase(){
    if ($this->isDatabaseSelected()) {
      return;
    }
    
    if (!$this->createDB()) {
      die("Database creation failed: " . $this->conn->connect_error);
      exit();
    }
  }

  private function initializeTable(){
    $this->isDatabaseSelected();
    if (!$this->createTable()) {
      die("Table creation failed: " . $this->conn->connect_error);
      exit();
    }
  }

  private function isDatabaseSelected(){
    return mysqli_select_db($this->conn, $this->_dbname);
  }

  private function createDB(){
    $sql = 'CREATE DATABASE '.$this->_dbname;
    return mysqli_query($this->conn, $sql);
  }

  private function createTable(){
    $sql = "CREATE TABLE IF NOT EXISTS {$_ENV['DATABASE']} (
          id int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
          name varchar(255) NOT NULL COMMENT 'product name',
          price double NOT NULL COMMENT 'product salary',
          sku varchar(255) NOT NULL COMMENT 'product age',
          image text NOT NULL COMMENT 'product image',
          PRIMARY KEY (id)
        ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='datatable product' AUTO_INCREMENT=64 ;";
    return mysqli_query($this->conn, $sql);
  }

  private function connectionError($con){
    return $con->connect_err;
  }
}
 
?>