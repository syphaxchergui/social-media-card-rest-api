<?php

class User{
    //db stuff
    private $conn;
    private $table = 'users';
    

    //item properties
    public $id;
    public $name;
    public $phone_number;
    public $password;
    public $otp_code;
    public $password_recived;

    //constructor with db connection
    public function __construct($db){
        $this->conn = $db;
    }

    //getting items from the database
    public function read(){
        //create query
        $query = 'SELECT u.id, u.name, u.phone_number, u.password, u.otp_code
        FROM '.$this->table .' u';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //execute query
        $stmt->execute();

        return $stmt;
    }

    //getting a single user from the database
    public function read_single(){
        //create query
        $query = 'SELECT u.id, u.name, u.phone_number, u.otp_code
        FROM '.$this->table .' u WHERE u.id= ? LIMIT 1';

        //prepare statement
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);

        //execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->phone_number = $row['phone_number'];
        $this->otp_code = $row['otp_code'];
    }

    //login
    public function login(){
        //create query
        $query = 'SELECT u.id, u.name, u.phone_number, u.password
        FROM '.$this->table .' u WHERE u.phone_number= '.$this->phone_number.' LIMIT 1';

        //prepare statement
        $stmt = $this->conn->prepare($query);
        
        //clean data
        $this->phone_number  = htmlspecialchars(strip_tags($this->phone_number));
        $this->password_recived  = htmlspecialchars(strip_tags($this->password_recived));

        //binding of params
        $stmt->bindParam(':phone_number', $this->phone_number);
        $stmt->bindParam(':password', $this->password_recived);

        //execute the query
        if($stmt->execute()){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->password = $row['password'];
            if($this->password == $this->password_recived) {
                return true;
            }
        }

        return false;
    } 

    //create an acount
    public function signUp() {
        //generate an opt code
        $otp = mt_rand(1000,9999);

        //verify if user exist 
        $query_verification = 'SELECT u.id, u.name, u.phone_number
        FROM '.$this->table .' u WHERE u.phone_number= '.$this->phone_number.' LIMIT 1';

        //create query
        $query = 'INSERT INTO '.$this->table.' SET name= :name, phone_number= :phone_number, password= :password, otp_code= '.$otp.'';

        //prepare the statement
        $stmt_verification = $this->conn->prepare($query_verification);
        $stmt = $this->conn->prepare($query);

        //clean the data
        $this->name         = htmlspecialchars(strip_tags($this->name));
        $this->phone_number = htmlspecialchars(strip_tags($this->phone_number));
        $this->password     = htmlspecialchars(strip_tags($this->password));

        //bind the params
        $stmt_verification->bindParam(':phone_number', $this->phone_number);

        //execute the verification query
        if($stmt_verification->execute()){
            $row = $stmt_verification->fetch(PDO::FETCH_ASSOC);
            if($row['id'] != null) {
                return false;
            }
        }

        //bind the params
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':phone_number', $this->phone_number);
        $stmt->bindParam(':password', $this->password); 

        //execute the query
        if($stmt->execute()){
            return true;
        } 

        //if error
        return false;
    }

    //update user
    public function update() {
        //create query
        $query = 'UPDATE '.$this->table.' SET name= :name, phone_number= :phone_number, password= :password WHERE id= :id';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //clean the data
        $this->id           = htmlspecialchars(strip_tags($this->id));
        $this->name         = htmlspecialchars(strip_tags($this->name));
        $this->phone_number = htmlspecialchars(strip_tags($this->phone_number));
        $this->password     = htmlspecialchars(strip_tags($this->password));

        //bind params
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':phone_number', $this->phone_number);
        $stmt->bindParam(':password', $this->password); 

        //execute the query
        if($stmt->execute()){
            return true;
        } 

        //if error
        return false;
    }

}