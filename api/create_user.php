<?php

//headers 
header('Access-Control-Allow-Origin: *');
header('Content-Type: aplication/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Header, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

//initializing the api
include_once('../core/initialize.php');

//instantiate user
$user = new User($db);

//get raw poster data
$data = json_decode(file_get_contents("php://input"));

$user->name = $data->name; 
$user->phone_number = $data->phone_number; 
$user->password = $data->password; 

//create user
if($user->signUp()){
    echo json_encode(
        array('error' => 'false')
    );
} else {
    echo json_encode(
        array('error' => 'true')
    );
}
