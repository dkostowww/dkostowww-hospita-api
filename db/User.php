<?php

class User{
    private $db;
    private $db_table = "user";
    public $id;
    public $email;
    public $first_name;
    public $last_name;
    public $type;
    public $workplace_id;
    public $workplace_name;
    public $created_at;
    public $result;


    public function __construct($db){
        $this->db = $db;
    }

    public function getUsers(){
        $sqlQuery = "SELECT u.id, u.email ,u.first_name, u.last_name, u.type, h.name AS hospital_name , u.created_at FROM user u LEFT JOIN hospital h ON u.workplace_id = h.id ORDER BY u.id;";
        $this->result = $this->db->query($sqlQuery);
        return $this->result;
    }

    public function getUsersByHospitalId($workplace_id){
        $sqlQuery = "SELECT u.id, u.email ,u.first_name, u.last_name, u.type, h.id AS hospital_id, h.name AS hospital_name , u.created_at FROM user u LEFT JOIN hospital h ON u.workplace_id = h.id WHERE h.id = '".$workplace_id."'";
        $this->result = $this->db->query($sqlQuery);
        return $this->result;
    }

    public function getUsersByHospitalName($workplace_name){
        $sqlQuery = "SELECT u.id, u.email ,u.first_name, u.last_name, u.type, h.id AS hospital_id, h.name AS hospital_name , u.created_at FROM user u LEFT JOIN hospital h ON u.workplace_id = h.id WHERE h.name = '".$workplace_name."'";
        $this->result = $this->db->query($sqlQuery);
        return $this->result;
    }

    public function createUser(){
        // Sanitize input
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->first_name=htmlspecialchars(strip_tags($this->first_name));
        $this->last_name=htmlspecialchars(strip_tags($this->last_name));
        $this->type=htmlspecialchars(strip_tags($this->type));
        $this->workplace_id=htmlspecialchars(strip_tags($this->workplace_id));
        $this->created_at=htmlspecialchars(strip_tags($this->created_at));

        $sqlQuery = "INSERT INTO `user` (`email`, `first_name`, `last_name`, `type`, `workplace_id`, `created_at`) VALUES ('".$this->email."', '".$this->first_name."', '".$this->last_name."', '".$this->type."', NULLIF('$this->workplace_id',''), NOW());";

        $this->db->query($sqlQuery);
        if($this->db->affected_rows > 0){
            return true;
        }
        return false;
    }

    public function updateUser(){
        // Sanitize input
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->first_name=htmlspecialchars(strip_tags($this->first_name));
        $this->last_name=htmlspecialchars(strip_tags($this->last_name));
        $this->type=htmlspecialchars(strip_tags($this->type));
        $this->workplace_id=htmlspecialchars(strip_tags($this->workplace_id));
        $this->created_at=htmlspecialchars(strip_tags($this->created_at));

        $sqlQuery = "UPDATE user SET email= '".$this->email."', first_name = '".$this->first_name."', last_name = '".$this->last_name."', type = '".$this->type."', workplace_id = $this->workplace_id WHERE id = ".$this->id;

        $this->db->query($sqlQuery);
        if($this->db->affected_rows > 0){
            return true;
        }
        return false;
    }

    function deleteUser(){
        $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ".$this->id;
        $this->db->query($sqlQuery);
        if($this->db->affected_rows > 0){
            return true;
        }
        return false;
    }
}
