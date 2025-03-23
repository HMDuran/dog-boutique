<?php
require_once __DIR__ . '/../vendor/autoload.php'; 

use Dotenv\Dotenv;

class Database {
    private $conn;
    public function getConnection() {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../'); 
        $dotenv->load();

        $host = $_ENV['DB_HOST'];
        $db_name = $_ENV['DB_NAME'];
        $username = $_ENV['DB_USER'];
        $password = $_ENV['DB_PASS'];

        $this->conn = null;
        try {   
            $this->conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>