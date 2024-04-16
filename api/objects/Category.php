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

    // read categories

    function read(){

        // select all query
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY name";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt;

    }
}
?>