<?php
class Orders {
    private $conn;
    private $table_name = "orders";
    public $id;
    public $user_id;
    public $total_amount;
    public $status;
    public $created_at;
    public $updated_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    function create($orderItems) {
        // Start transaction
        $this->conn->beginTransaction();

        try {
            // Insert order
            $query = "INSERT INTO " . $this->table_name . " SET user_id=:user_id, total_amount=:total_amount, status=:status, created_at=:created_at, updated_at=:updated_at";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":user_id", $this->user_id);
            $stmt->bindParam(":total_amount", $this->total_amount);
            $stmt->bindParam(":status", $this->status);
            $stmt->bindParam(":created_at", $this->created_at);
            $stmt->bindParam(":updated_at", $this->updated_at);
            $stmt->execute();

            $order_id = $this->conn->lastInsertId();

            foreach ($orderItems as $item) {
                $orderItem = new OrderItems($this->conn);
                $orderItem->order_id = $order_id;
                $orderItem->product_id = $item['product_id'];
                $orderItem->quantity = $item['quantity'];
                $orderItem->total_price = $item['total_price'];
                $orderItem->created_at = date('Y-m-d H:i:s');
                $orderItem->updated_at = date('Y-m-d H:i:s');
                $orderItem->create();
            }
            $this->conn->commit();

            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    function readDetails() {
        $query = "SELECT o.id, u.first_name, u.last_name FROM " . $this->table_name . " o ";
        $query .= "LEFT JOIN users u ON o.user_id = u.id ";
        $query .= "WHERE o.user_id = :user_id";  // Change from o.id to o.user_id
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $this->user_id);  // Change from :id to :user_id
        $stmt->execute();
        return $stmt;
    }
    
}
?>