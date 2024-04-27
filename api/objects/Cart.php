<?php 
class Cart
{
    private $conn;
    private $table_name = "carts";

    public $id;
    public $user_id;
    public $product_id;
    public $quantity;
    public $total_amount;
    public $created_at;
    public $updated_at;

    public function __construct($db){
        $this->conn = $db;
    }

    function addToCart(){
        $query = "SELECT id, quantity FROM " . $this->table_name . " WHERE user_id = :user_id AND product_id = :product_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":product_id", $this->product_id);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $existingQuantity = $row['quantity'];
            $newQuantity = $existingQuantity + $this->quantity;
    
            $queryPrice = "SELECT price FROM products WHERE id = :product_id";
            $stmtPrice = $this->conn->prepare($queryPrice);
            $stmtPrice->bindParam(":product_id", $this->product_id);
            $stmtPrice->execute();
            $price = $stmtPrice->fetchColumn();
            $totalAmount = $newQuantity * $price;
    
            $query = "UPDATE " . $this->table_name . " SET quantity = :quantity, total_amount = :total_amount WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":quantity", $newQuantity);
            $stmt->bindParam(":total_amount", $totalAmount);
            $stmt->bindParam(":id", $row['id']);
            if ($stmt->execute()) {
                return true;
            }
        } else {
            $queryPrice = "SELECT price FROM products WHERE id = :product_id";
            $stmtPrice = $this->conn->prepare($queryPrice);
            $stmtPrice->bindParam(":product_id", $this->product_id);
            $stmtPrice->execute();
            $price = $stmtPrice->fetchColumn();
            $totalAmount = $this->quantity * $price;

            $query = "INSERT INTO " . $this->table_name . " 
                      SET user_id=:user_id, product_id=:product_id, 
                      quantity=:quantity, total_amount=:total_amount, 
                      created_at=:created_at, updated_at=:updated_at";
            $stmt = $this->conn->prepare($query);
    
            $this->user_id=htmlspecialchars(strip_tags($this->user_id));
            $this->product_id=htmlspecialchars(strip_tags($this->product_id));
            $this->quantity=htmlspecialchars(strip_tags($this->quantity));
            $this->total_amount=htmlspecialchars(strip_tags($totalAmount)); 
            $this->updated_at = htmlspecialchars(strip_tags(date('Y-m-d H:i:s')));
    
            $stmt->bindParam(":user_id", $this->user_id);
            $stmt->bindParam(":product_id", $this->product_id);
            $stmt->bindParam(":quantity", $this->quantity);
            $stmt->bindParam(":total_amount", $totalAmount); 
            $stmt->bindParam(":created_at", $this->created_at);
            $stmt->bindParam(":updated_at", $this->updated_at);
    
            if($stmt->execute()){
                return true;
            }
        }
        return false;
    }
    
    function count($user_id) {
        $query = "SELECT SUM(quantity) AS total_quantity FROM " . $this->table_name . " WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
    
        $stmt->bindParam(":user_id", $user_id);
    
        if ($stmt->execute()) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $total_quantity = intval($row['total_quantity']);
            return $total_quantity;
        }
    }
    
    function read($user_id) {
        $query = "SELECT c.*, p.name AS product_name, p.price, p.image 
                  FROM " . $this->table_name . " c
                  LEFT JOIN products p ON c.product_id = p.id
                  WHERE c.user_id = :user_id
                  ORDER BY c.created_at DESC";
    
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();
    
        $cartItems = array();
    
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $cartItems[] = array(
                "id" => $row['id'],
                "product_id" => $row['product_id'],
                "product_name" => $row['product_name'],
                "price" => $row['price'],
                "image" => $row['image'],
                "quantity" => $row['quantity'],
                "total_amount" => $row['quantity'] * $row['price']
            );
        }
    
        return $cartItems;
    }

    function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
    
        if ($stmt->execute()) {
            return true;
        }
    
        return false;
    }

    function updateQuantity($id, $quantity) {
        $query = "SELECT product_id FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $product_id = $row['product_id'];
    
        $queryPrice = "SELECT price FROM products WHERE id = :product_id";
        $stmtPrice = $this->conn->prepare($queryPrice);
        $stmtPrice->bindParam(":product_id", $product_id);
        $stmtPrice->execute();
        $price = $stmtPrice->fetchColumn();
    
        $totalAmount = $quantity * $price;
    
        $query = "UPDATE " . $this->table_name . " SET quantity = :quantity, total_amount = :total_amount WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":quantity", $quantity);
        $stmt->bindParam(":total_amount", $totalAmount);
        $stmt->bindParam(":id", $id);
        
        if ($stmt->execute()) {
            return true;
        }
        
        return false;
    }
    
    function readByIds($ids) {
      $placeholders = implode(',', array_fill(0, count($ids), '?'));
    
        $query = "SELECT c.*, p.image, p.name, p.price 
                  FROM " . $this->table_name . " c
                  LEFT JOIN Products p ON c.product_id = p.id
                  WHERE c.id IN ($placeholders)";
    
        $stmt = $this->conn->prepare($query);
    
        foreach ($ids as $key => $id) {
            $stmt->bindValue(($key + 1), $id);
        }
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
?>