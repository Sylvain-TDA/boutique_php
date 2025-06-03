<?php


function connection($user, $password): PDO
{
    static $pdo = null;

    if ($pdo === null) {
        try {
            // On se connecte à MySQL
            $mysqlClient = new PDO('mysql:host=127.0.0.1;dbname=store;charset=utf8', "$user", "$password");
        } catch (Exception $e) {
            // En cas d'erreur, on affiche un message et on arrête tout
            die('Erreur : ' . $e->getMessage());
        }
    }
    return $mysqlClient;
}


function getTable($table, $user, $password): array
{
    $sqlQuery = "SELECT * FROM `$table`";
    $productsName = connection($user, $password)->prepare($sqlQuery);
    $productsName->execute();
    $table1 = $productsName->fetchAll(PDO::FETCH_ASSOC);
    return $table1;
}

function getProductName(): array
{
    $pdo = connection("John", "John1");
    $sqlQuery = "SELECT name FROM products";
    $stmt = $pdo->prepare($sqlQuery); // stmt stand for statement
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function excludeProductsShortage($table, $user, $password): array
{
    $pdo = connection("John", "John1");
    $sqlQuery = "SELECT * FROM $table WHERE quantity<>0";
    $stmt = $pdo->prepare($sqlQuery);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function changingProducts($choice)
{
    if ($choice == "shortage") {
        $products = excludeProductsShortage("products", "John", "John1");
    } else {
        $products = getTable("products", "John", "John1");
    }
    return $products;
}

function listingOrders()
{
    $sqlQuery =
        "SELECT o.number, sum(p.price * op.quantity) AS total_commande, op.order_id
        FROM products p
        JOIN order_product op ON p.id = op.product_id 
        JOIN orders o ON op.order_id = o.id
        GROUP BY o.number";

    $queryConnection = connection("John", "John1")->prepare($sqlQuery);
    $queryConnection->execute();
    return $queryConnection->fetchAll();
}

function todayOrders(): array
{
    $sqlQuery =
        "SELECT
        SUM(p.price * op.quantity) AS total
        FROM order_product op
        JOIN orders o ON o.id=op.order_id
        JOIN products p ON op.product_id = p.id
        WHERE date(date) = CURDATE()";

    $queryConnection = connection("John", "John1")->prepare($sqlQuery);
    $queryConnection->execute();
    return $queryConnection->fetchAll();
}

function addingProduct($name, $price, $description, $weight, $url, $quantity, $availability, $categories_id, $discount)
{
    $sqlQuery =
        "INSERT INTO `products` (`name`, `price`, `description`, `weight`, `img_url`, `quantity`, `availability`, `categories_id`, `discount`)
        VALUES (:name, :price, :description, :weight, :url, :quantity, :availability, :categories_id, :discount)";

    $queryConnection = connection("John", "John1")->prepare($sqlQuery);
    
    return $queryConnection->execute([
        ':name' => $name,
        ':price' => $price,
        ':description' => $description,
        ':weight' => $weight,
        ':url' => $url,
        ':quantity' => $quantity,
        ':availability' => $availability,
        ':categories_id' => $categories_id,
        ':discount' => $discount
    ]);
}

function placeOrder($total, $shipping_cost, $total_weight, $customer_id, $carrier_id, $commande)
{
    $ordersQuery =
        "INSERT INTO `orders` (`total`, `shipping_cost`, `total_weight`, `customer_id`, `carrier_id`)
        VALUES (:total, :shipping_cost, :total_weight, :customer_id, :carrier_id)";

    $queryConnection = connection("John", "John1");
    $placeOrders = $queryConnection->prepare($ordersQuery);
    $placeOrders->execute([
        ':total' => $total,
        ':shipping_cost' => $shipping_cost,
        ':total_weight' => $total_weight,
        ':customer_id' => $customer_id,
        ':carrier_id' => $carrier_id
    ]);

    // Alimentation de la table order_product en même temps que l'on passe commande
    $queryIdSelected = "SELECT MAX(id) FROM orders";
    $placeOrdersProducts = $queryConnection->prepare($queryIdSelected);
    $placeOrdersProducts->execute();
    $idSelected = $placeOrdersProducts->fetchAll();
    $idCommande = $idSelected[0][0];

    foreach ($commande as $key => $element) {
        if (strpos($key, "commande") === 0 && is_array($element)) {
            $productId = $element[6];
            $quantity = $element[1];
            $total_weight = $element[2];
            placeOrerProduct($quantity, $total_weight, $productId, $idCommande);
        }
    }
    ;
}

function placeOrerProduct($quantity, $total_weight, $product_id, $order_id)
{
    $ordersQuery =
        "INSERT INTO `order_product` (`quantity`, `total_weight`, `product_id`, `order_id`)
        VALUES (:quantity, :total_weight, :product_id, :order_id)";

    $queryConnection = connection("John", "John1")->prepare($ordersQuery);
    $orderAdded = $queryConnection->execute([
        ':quantity' => $quantity,
        ':total_weight' => $total_weight,
        ':product_id' => $product_id,
        ':order_id' => $order_id
    ]);
    return $orderAdded;
}

function getProductQuantityAvailable($product_id)
{
    $query =
        "SELECT quantity FROM products WHERE id=:id";
    $queryConnection = connection("John", "John1")->prepare($query);
    $queryConnection->execute([
        "id" => $product_id,
    ]);
    $product = $queryConnection->fetch(PDO::FETCH_ASSOC);
    return $product["quantity"];
}

function deleteOrder($order_id)
{
    $query =
        "DELETE  FROM order_product WHERE order_id=:order_id";
    $queryConnection = connection("business", "motdepasse")->prepare($query);
    $queryConnection->execute([
        "order_id" => $order_id,
    ]);
}
?>