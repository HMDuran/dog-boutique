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
        $this->conn->beginTransaction();

        try {
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
        $query .= "WHERE o.user_id = :user_id"; 
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $this->user_id); 
        $stmt->execute();
        return $stmt;
    }

    function readWithItems() {
        $query = "SELECT o.id, DATE(o.created_at) as created_at, u.first_name, u.last_name, ";
        $query .= "GROUP_CONCAT(CONCAT(oi.quantity, 'x ', p.name) SEPARATOR '<br>') AS order_items, o.total_amount, o.status ";
        $query .= "FROM orders o ";
        $query .= "LEFT JOIN order_items oi ON o.id = oi.order_id ";
        $query .= "LEFT JOIN products p ON oi.product_id = p.id ";
        $query .= "LEFT JOIN users u ON o.user_id = u.id ";
        $query .= "GROUP BY o.id ";
        $query .= "ORDER BY o.id DESC"; 

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    function updateStatus() {
        $query = "UPDATE " . $this->table_name . " SET status = :status WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function readOne() {
        $query = "SELECT
                    id, status
                FROM
                    " . $this->table_name . "
                WHERE
                    id = ?
                LIMIT
                    0,1";
    
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
            $this->id = $row['id'];
            $this->status = $row['status'];
    
            return true;
        }
            $this->id = null;
        $this->status = null;
    
        return false;
    }

    function deleteOrder($orderId) {
        $query = "DELETE FROM orders WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $orderId);
    
        if ($stmt->execute()) {
            return true;
        }
    
        return false;
    }
}
?>