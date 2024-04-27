<?php
class User {
    private $conn;
    private $table_name = "users";

    public $id;
    public $first_name;
    public $last_name;
    public $email;
    public $password;
    public $phone_number;
    public $delivery_address;
    public $role;
    public $created_at;
    public $updated_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    function login() {
        if (!isset($this->email) || !isset($this->password)) {
            return false;
        }

        $query = "SELECT id, email, password, role FROM {$this->table_name} WHERE email = :email LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $this->email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if (password_verify($this->password, $row['password'])) {
                $this->id = $row['id'];
                $this->role = $row['role'];
                
                unset($row['password']);

                return $row;
            }
        }
        return false;
    }

    function getUser($id = null) {
        $query = "SELECT * FROM {$this->table_name} WHERE id = :id LIMIT 0,1";

        $stmt = $this->conn->prepare($query);

        if (!$id) {
            $stmt->bindParam(':id', $this->id);
        } else {
            $stmt->bindParam(':id', $id);
        }

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            unset($row['password']);
            return $row;
        }

        return [];
    }

    function create() {
        if (!preg_match('/^[A-Za-z]+$/', $this->first_name) || 
           !preg_match('/^[A-Za-z]+$/', $this->last_name)) {
            return false;
        }

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        if(strlen($this->password) < 6 || strlen($this->password) > 20) {
            return false;
        }

        if (!preg_match('/^[0-9]+$/', $this->phone_number)) {
            return false;
        }

        $hashed_password = password_hash($this->password, PASSWORD_DEFAULT);

        $query = "INSERT INTO {$this->table_name}
            SET
                first_name=:first_name,
                last_name=:last_name,
                email=:email,
                password=:password,
                phone_number=:phone_number,
                delivery_address=:delivery_address,
                role=:role,
                created_at=:created_at";
        
        $stmt = $this->conn->prepare($query);

        $this->first_name = htmlspecialchars(strip_tags($this->first_name));
        $this->last_name = htmlspecialchars(strip_tags($this->last_name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->phone_number = htmlspecialchars(strip_tags($this->phone_number));
        $this->delivery_address = htmlspecialchars(strip_tags($this->delivery_address));
        $this->role = "customer";
        $this->created_at = htmlspecialchars(strip_tags($this->created_at));

        $stmt->bindParam(":first_name", $this->first_name);
        $stmt->bindParam(":last_name", $this->last_name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $hashed_password);
        $stmt->bindParam(":phone_number", $this->phone_number);
        $stmt->bindParam(":delivery_address", $this->delivery_address);
        $stmt->bindParam(":role", $this->role);
        $stmt->bindParam(":created_at", $this->created_at);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}   
?>