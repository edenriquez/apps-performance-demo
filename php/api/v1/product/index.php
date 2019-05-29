<?php 
// ROUTE: /api/v1/product
include("../../../model/product/connection.php");
include("../../../env.php");
include('../../../model/product/productRepository.php');
include('../errors/index.php');

$errors = new ApiErrors();
$db = new Connection();
$connection =  $db->connect();

$request_method=$_SERVER["REQUEST_METHOD"];

switch($request_method) {
    case 'GET':
      $product = new Repository();
      $product->getAll($connection);
    break;
    default:
	    $errors->notAllowed();
	break;
}