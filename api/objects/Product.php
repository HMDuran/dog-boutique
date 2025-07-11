<?php
    class Product {
        private $conn;
        private $table_name = "products";

        public $id;
        public $name;
        public $image;
        public $description;
        public $price;
        public $stock;
        public $categoryid;
        public $category_nam;
        public $created_at;
        public $updated_at;

        public function __construct($db){
            $this->conn = $db;
        }

        function read() {
            $query = "SELECT p.*, c.name AS category_name
                FROM {$this->table_name} p
                    LEFT JOIN categories c 
                        ON p.categoryid = c.id";

            $stmt = $this->conn->prepare($query);

            $stmt->execute();
            return $stmt;
        }

        function read_filter($category) {
            if ($category === "all") {
                $query = "SELECT p.*, c.name AS category_name
                    FROM {$this->table_name} p
                        LEFT JOIN categories c 
                            ON p.categoryid = c.id";
            } else {
                $query = "SELECT p.*, c.name AS category_name
                    FROM {$this->table_name} p
                        LEFT JOIN categories c 
                            ON p.categoryid = c.id
                    WHERE c.name = :category";
            }

                $stmt = $this->conn->prepare($query);
                if ($category !== 'all') {
                    $stmt->bindParam(':category', $category);
                }

                $stmt->execute();

                return $stmt;
        }

        function readOne() {
            $query = "SELECT
            c.name AS category_name, 
            p.id as p_id, p.name, p.description, p.price, p.stock, p.image, p.categoryid, p.created_at
            FROM
                " . $this->table_name . " p
            LEFT JOIN
                categories c
                    ON p.categoryid = c.id
            WHERE
                p.id = :id
            LIMIT
                0,1";

            $stmt = $this->conn->prepare( $query );
            $stmt->bindParam(":id", $this->id);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->category_name = $row['category_name'];
            $this->id = $row['p_id'];
            $this->name = $row['name'];
            $this->image = $row['image'];
            $this->description = $row['description'];
            $this->price = $row['price'];
            $this->stock = $row['stock'];
            $this->categoryid = $row['categoryid'];
            $this->created_at = $row['created_at'];
        }

        function create() {
            $query = "INSERT INTO {$this->table_name}
                SET
                    name=:name,
                    image=:image,
                    description=:description,
                    price=:price,
                    stock=:stock,
                    categoryid=:categoryid,
                    created_at=:created_at";

            $stmt = $this->conn->prepare($query);

            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->image = htmlspecialchars(strip_tags($this->image));
            $this->description = htmlspecialchars(strip_tags($this->description));
            $this->price = htmlspecialchars(strip_tags($this->price));
            $this->stock = htmlspecialchars(strip_tags($this->stock));
            $this->categoryid = htmlspecialchars(strip_tags($this->categoryid));
            $this->created_at = htmlspecialchars(strip_tags($this->created_at));

            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":image", $this->image);
            $stmt->bindParam(":description", $this->description);
            $stmt->bindParam(":price", $this->price);
            $stmt->bindParam(":stock", $this->stock);
            $stmt->bindParam(":categoryid", $this->categoryid);
            $stmt->bindParam(":created_at", $this->created_at);

            if($stmt->execute()) {
                return true;
            }
            return false;
        }

        function delete() { 
            $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $this->id = htmlspecialchars(strip_tags($this->id));
            $stmt->bindParam(1, $this->id);
            if($stmt->execute()){
                return true;
            }
            return false;
        }

        function update() { 
            if ($this->name !== null) {
                $query = "UPDATE " . $this->table_name . "
                        SET
                            name=:name,
                            description=:description,
                            price=:price,
                            stock=:stock,
                            categoryid=:categoryid,
                            image=:image
                        WHERE
                            id=:id";

                $stmt = $this->conn->prepare($query);
                
                $this->name = htmlspecialchars(strip_tags($this->name));
                $this->image = htmlspecialchars(strip_tags($this->image));
                $this->description = htmlspecialchars(strip_tags($this->description));
                $this->price = htmlspecialchars(strip_tags($this->price));
                $this->stock = htmlspecialchars(strip_tags($this->stock));
                $this->categoryid = htmlspecialchars(strip_tags($this->categoryid));

                $stmt->bindParam(':name', $this->name);
                $stmt->bindParam(':description', $this->description);
                $stmt->bindParam(':price', $this->price);
                $stmt->bindParam(':stock', $this->stock);
                $stmt->bindParam(':categoryid', $this->categoryid);
                $stmt->bindParam(':image', $this->image);
                $stmt->bindParam(':id', $this->id);
                 
                if ($stmt->execute()) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false; 
            }
        }

        function updateStock($product_id, $quantity) {
            $query = "UPDATE " . $this->table_name . " SET stock = stock - :quantity WHERE id = :product_id";

            $stmt = $this->conn->prepare($query);
            
            $stmt->bindParam(':quantity', $quantity);
            $stmt->bindParam(':product_id', $product_id);
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        }
    } 
?>