<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json; charset=UTF-8');

    include_once '../../config/Database.php';
    include_once '../objects/Product.php';

    $database = new Database();
    $db = $database->getConnection();

    $product = new Product($db);
    
    $stmt = $product->read();
    $num = $stmt->rowCount();

    if ($num > 0) {
        $products_arr = array();
        $products_arr['data'] = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $product_item = array(
                'id' => $id,
                'name' => $name,
                'image' => $image,
                'description' => $description,
                'price' => $price,
                'stock' => $stock,
                'category_name' => $category_name,
                'created_at' => $created_at,
                'updated_at' => $updated_at
            );

            array_push($products_arr['data'], $product_item);
        }
        http_response_code(200);
        echo json_encode($products_arr);
    } else {
        http_response_code(404);
        echo json_encode(array('message' => 'No products found'));
    }
?>