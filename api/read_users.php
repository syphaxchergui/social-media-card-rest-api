<?php

//headers 
header('Access-Control-Allow-Origin: *');
header('Content-Type: aplication/json');

//initializing the api
include_once('../core/initialize.php');

//instantiate item
$user = new User($db);

//link query
$result = $user->read();

//get the row count
$num = $result->rowCount();

if($num > 0) {
    $user_arr = array();
    $user_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $user_item = array(
            'id' => $id,
            'name' => $name,
            'phone_number' => $phone_number,
            'password' => $password,
            'otp_code' => $otp_code
        );
        array_push($user_arr['data'], $user_item);
    }
    //convert to JSON and output
    echo json_encode($user_arr);

} else {
    echo json_encode(array('message' => 'No user found'));
}