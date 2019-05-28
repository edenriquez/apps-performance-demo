<?php 

include("../../../../model/connection.php");
include("../../../../env.php");
include('../../../../model/productRepository.php');
include('../../errors/index.php');

$errors = new ApiErrors();
$db = new Connection();
$connection =  $db->connect();


$post = file_get_contents('php://input');
$request_method=$_SERVER["REQUEST_METHOD"];
/*
curl -X POST  -d '{"name":"product","price":"3.00","sku":"AB-0001","image":"shorturl.at/celyX"}' http://localhost/api/v1/product/
*/

switch($request_method) {
    case 'POST':
      $product = new Repository($post);
		  $product->create($connection);
      break;
      default:
	    $errors->notAllowed();
	break;
}
