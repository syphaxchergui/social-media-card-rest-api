<?php

//headers 
header('Access-Control-Allow-Origin: *');
header('Content-Type: aplication/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Header, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

//initializing the api
include_once('../core/initialize.php');

//instantiate link

$link = new Link($db);

//get raw poster data
$data = json_decode(file_get_contents("php://input"));

$link->id = $data->id; 

//delete link
if($link->delete()){
    echo json_encode(
        array('error' => 'false')
    );
} else {
    echo json_encode(
        array('error' => 'true')
    );
}