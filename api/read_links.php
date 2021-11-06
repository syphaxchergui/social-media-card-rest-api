<?php

//headers 
header('Access-Control-Allow-Origin: *');
header('Content-Type: aplication/json');

//initializing the api
include_once('../core/initialize.php');

//instantiate link

$link = new Link($db);
$link->user_id = isset($_GET['user_id']) ? $_GET['user_id'] : die();

//link query
$result = $link->read();

//get the row count
$num = $result->rowCount();

if($num > 0) {
    $link_arr = array();
    $link_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $link_item = array(
            'id' => $id,
            'item_id' => $item_id,
            'link' => $link,
            'icon' => $item_icon,
            'color' => $item_color
        );
        array_push($link_arr['data'], $link_item);
    }
    //convert to JSON and output
    echo json_encode($link_arr);

} else {
    echo json_encode(array('message' => 'No link found'));
}