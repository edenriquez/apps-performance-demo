<?php
header("Content-Type: application/json; charset=UTF-8");

$response = array();
$counter = ($counter > 0) ? $counter++: 1;
$response =  array(
    "count" => $counter,
    "ping"  => "pong"
);
echo json_encode($response);
