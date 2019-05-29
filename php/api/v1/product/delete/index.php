<?php 

include("../../../model/product/connection.php");
include("../../../../env.php");
include('../../../model/product/productRepository.php');
include('../../errors/index.php');

$errors = new ApiErrors();
$db = new Connection();
$connection =  $db->connect();


$post = file_get_contents('php://input');
$request_method=$_SERVER["REQUEST_METHOD"];

switch($request_method) {
    case 'GET':
      $product = new Repository();
		  $product->delete($connection, $_GET['id']);
      break;
      default:
	    $errors->notAllowed();
	break;
}
