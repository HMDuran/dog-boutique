<?php
class Category {

    // database connection and table name   
    private $conn;
    private $table_name = "categories";

    // object properties
    public $id;
    public $name;

    // constructor with $db as database connection
    public function __construct($db) {
        $this->conn = $db;
    }

    function read(){
        $query = "SELECT * FROM " . $this->table_name;
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt;
    }

    function readOne(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->name = $row['name'];
    }

    function create() {
        $query = "INSERT INTO " . $this->table_name . " SET name=:name";
        $stmt = $this->conn->prepare($query);
        $this->name=htmlspecialchars(strip_tags($this->name));
        $stmt->bindParam(":name", $this->name);
        
        if($stmt->execute()){
            return true;
        }
        
        return false;
    }

    function delete(){
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $this->id=htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id);
        
        if($stmt->execute()){
            return true;
        }
        
        return false;
    }

    function update(){
        $query = "UPDATE " . $this->table_name . " SET name=:name WHERE id=:id";
        
        $stmt = $this->conn->prepare($query);

        $this->name=htmlspecialchars(strip_tags($this->name));

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":id", $this->id);
        
        if($stmt->execute()){
            return true;
        }  else {
            return false;
        }
    }
}
?>