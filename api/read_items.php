<?php

//headers 
header('Access-Control-Allow-Origin: *');
header('Content-Type: aplication/json');

//initializing the api
include_once('../core/initialize.php');

//instantiate item
$item = new Item($db);

//link query
$result = $item->read();

//get the row count
$num = $result->rowCount();

if($num > 0) {
    $item_arr = array();
    $item_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $item_item = array(
            'id' => $id,
            'name' => $name,
            'icon' => $icon,
            'color' => $color
        );
        array_push($item_arr['data'], $item_item);
    }
    //convert to JSON and output
    echo json_encode($item_arr);

} else {
    echo json_encode(array('message' => 'No item found'));
}