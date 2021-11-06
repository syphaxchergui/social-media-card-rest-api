<?php

class Link{
    //db stuff
    private $conn;
    private $table = 'links';
   

    //link properties
    public $id;
    public $item_id;
    public $item_icon;
    public $item_color;
    public $user_id;
    public $link;

    //constructor with db connection
    public function __construct($db){
        $this->conn = $db;
    }

    //getting links from the database
    public function read(){
        //create query
        $query = 'SELECT * FROM (SELECT 
        l.id, l.item_id, i.color as item_color, i.icon as item_icon, l.user_id, l.link 
        FROM '.$this->table .' l 
        LEFT JOIN items i ON l.item_id = i.id ) a 
        WHERE a.user_id = '.$this->user_id .'';

        //prepare statement
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->user_id);
        //execute query
        $stmt->execute();

        return $stmt;
    }

    //getting a single link from the database
    public function read_single(){
        //create query
        $query = 'SELECT 
        l.id, l.item_id, i.color as item_color, i.icon as item_icon, l.user_id, l.link 
        FROM '.$this->table .' l 
        LEFT JOIN items i ON l.item_id = i.id WHERE l.id= ? LIMIT 1';

        //prepare statement
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);

        //execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->id = $row['id'];
        $this->item_id = $row['item_id'];
        $this->item_color = $row['item_color'];
        $this->item_icon = $row['item_icon'];
        $this->link = $row['link'];
    }

    //create a link
    public function create(){
        //create query
        $query  = 'INSERT INTO '.$this->table.' SET item_id = :item_id, link = :link, user_id = :user_id';

        //prepare statement
        $stmt = $this->conn->prepare($query);
        
        //clean data
        $this->link     = htmlspecialchars(strip_tags($this->link));
        $this->user_id  = htmlspecialchars(strip_tags($this->user_id));
        $this->item_id  = htmlspecialchars(strip_tags($this->item_id));

        //binding of params
        $stmt->bindParam(':link', $this->link);
        $stmt->bindParam(':item_id', $this->item_id);
        $stmt->bindParam(':user_id', $this->user_id);

        //execute the query
        if($stmt->execute()){
            return true;
        }

        //print error if something goes wrong
        print_f("Error %s. \n", $stmt->error);
        return false;

    } 
    
    //update a link
    public function update(){
        //create query
        $query  = 'UPDATE '.$this->table.' SET item_id = :item_id, link = :link, user_id = :user_id WHERE id = :id';

        //prepare statement
        $stmt = $this->conn->prepare($query);
        
        //clean data
        $this->id       = htmlspecialchars(strip_tags($this->id));
        $this->link     = htmlspecialchars(strip_tags($this->link));
        $this->user_id  = htmlspecialchars(strip_tags($this->user_id));
        $this->item_id  = htmlspecialchars(strip_tags($this->item_id));

        //binding of params
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':link', $this->link);
        $stmt->bindParam(':item_id', $this->item_id);
        $stmt->bindParam(':user_id', $this->user_id);

        //execute the query
        if($stmt->execute()){
            return true;
        }

        //print error if something goes wrong
        print_f("Error %s. \n", $stmt->error);
        return false;
    }

    //delete a link
    public function delete(){
        //create the query
        $query = 'DELETE FROM '.$this->table. ' WHERE id = :id';

        //preapre the statment
        $stmt = $this->conn->prepare($query);

        //clean the data
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':id', $this->id);
        
        //execute the query
        if($stmt->execute()){
            return true;
        }

        //print error if something goes wrong
        print_f("Error %s. \n", $stmt->error);
        return false;
    }

}