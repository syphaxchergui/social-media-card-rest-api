<?php

//headers 
header('Access-Control-Allow-Origin: *');
header('Content-Type: aplication/json');

//initializing the api
include_once('../core/initialize.php');

//instantiate user

$user = new User($db);

$user->id = isset($_GET['id']) ? $_GET['id'] : die();

//user query
$user->read_single();

$user_item = array(
    'id' => $user->id,
    'name' => $user->name,
    'phone_number' => $user->phone_number,
    'otp_code' => $user->otp_code
);


print_r(json_encode($user_item));
