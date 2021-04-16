<?php

class Hospital{
    private $db;
    private $db_table = "hospital";
    public $id;
    public $name;
    public $address;
    public $phone;
    public $order;
    public $result;

    public function __construct($db){
        $this->db = $db;
    }

    public function getHospitals($order){
        $this->order = $order;
        $sqlQuery = "SELECT h.id, h.name, h.phone, h.address, COUNT(u.id) AS employees FROM hospital h LEFT JOIN user u ON h.id = u.workplace_id GROUP BY h.id ORDER BY employees $order";        $this->result = $this->db->query($sqlQuery);
        return $this->result;
    }

    public function createHospital(){
        // Sanitize input
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->address=htmlspecialchars(strip_tags($this->address));
        $this->phone=htmlspecialchars(strip_tags($this->phone));

        $sqlQuery = "INSERT INTO `hospital` (`name`, `address`, `phone`) VALUES ('".$this->name."', '".$this->address."', '".$this->phone."');";

        $this->db->query($sqlQuery);
        if($this->db->affected_rows > 0){
            return true;
        }
        return false;
    }

    public function updateHospital(){
        // Sanitize input
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->address=htmlspecialchars(strip_tags($this->address));
        $this->phone=htmlspecialchars(strip_tags($this->phone));

        $sqlQuery = "UPDATE `hospital` SET `name`= '".$this->name."', `address` = '".$this->address."', `phone` = '".$this->phone."' WHERE id = ".$this->id;

        $this->db->query($sqlQuery);
        if($this->db->affected_rows > 0){
            return true;
        }
        return false;
    }

    function deleteHospital(){
        $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ".$this->id;
        $this->db->query($sqlQuery);
        if($this->db->affected_rows > 0){
            return true;
        }
        return false;
    }
}
