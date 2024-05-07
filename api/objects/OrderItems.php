<?php 
class OrderItems {
    private $conn;
    private $table_name = "order_items";
    public $id;
    public $order_id;
    public $product_id;
    public $quantity;
    public $total_price;
    public $created_at;
    public $updated_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    function create() {
        $query = "INSERT INTO " . $this->table_name . " SET order_id = :order_id, product_id = :product_id, quantity = :quantity, total_price = :total_price, created_at = :created_at, updated_at = :updated_at";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":order_id", $this->order_id);
        $stmt->bindParam(":product_id", $this->product_id);
        $stmt->bindParam(":quantity", $this->quantity);
        $stmt->bindParam(":total_price", $this->total_price);
        $stmt->bindParam(":created_at", $this->created_at);
        $stmt->bindParam(":updated_at", $this->updated_at);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function deleteOrderItems($orderId) {
        $query = "DELETE FROM order_items WHERE order_id = :order_id";

        $stmt = $this->conn->prepare($query);
    
        $stmt->bindParam(':order_id', $orderId);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>