<?php

//headers 
header('Access-Control-Allow-Origin: *');
header('Content-Type: aplication/json');

//initializing the api
include_once('../core/initialize.php');

//instantiate link

$link = new Link($db);

$link->id = isset($_GET['id']) ? $_GET['id'] : die();

//link query
$link->read_single();

$link_item = array(
    'id' => $link->id,
    'item_id' => $link->item_id,
    'link' => $link->link,
    'icon' => $link->item_icon,
    'color' => $link->item_color
);


print_r(json_encode($link_item));
