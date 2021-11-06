<?php

class Item{
    //db stuff
    private $conn;
    private $table = 'items';

    //item properties
    public $id;
    public $icon;
    public $name;
    public $color;

    //constructor with db connection
    public function __construct($db){
        $this->conn = $db;
    }

    //getting items from the database
    public function read(){
        //create query
        $query = 'SELECT i.id, i.name, i.icon, i.color
        FROM '.$this->table .' i';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //execute query
        $stmt->execute();

        return $stmt;
    }

}