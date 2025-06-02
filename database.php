<?php


function connection($user, $password): PDO
{
    try {
        // On se connecte à MySQL
        $mysqlClient = new PDO('mysql:host=127.0.0.1;dbname=store;charset=utf8', "$user", "$password");
    } catch (Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : ' . $e->getMessage());
    }
    return $mysqlClient;
}

function getTable($table, $user, $password): array
{
    // On récupère tout le contenu de la table recipes
    $sqlQuery = "SELECT * FROM $table";
    $productsName = connection("$user", "$password")->prepare($sqlQuery);
    $productsName->execute();
    $table1 = $productsName->fetchAll();
    return $table1;
}

function getProductName(): array
{
    // On récupère tout le contenu de la table recipes
    $sqlQuery = "SELECT name FROM products";
    $productsName = connection("John", "John1")->prepare($sqlQuery);
    $productsName->execute();
    $productsName = $productsName->fetchAll();
    $name = [];
    foreach ($productsName as $key => $value) {
        array_push($name, $value["name"]);
    }
    return $name;
}


function getProductsShortage($table, $user, $password): array
{
    $sqlQuery = "SELECT * FROM $table WHERE quantity=0";
    $queryConnection = connection("$user", "$password")->prepare($sqlQuery);
    $queryConnection->execute();
    $shortage = $queryConnection->fetchAll();
    return $shortage;
}

function changingProducts($choice)
{
    if ($choice == "shortage") {
        $products = getProductsShortage("products", "John", "John1");
    } else {
        $products = getTable("products", "John", "John1");

    }
    return $products;
}

function listingOrders()
{
    $sqlQuery =
        "SELECT o.number, sum(p.price * op.quantity) AS total_commande
        FROM products p
        JOIN order_product op ON p.id = op.product_id 
        JOIN orders o ON op.order_id = o.id
        GROUP BY o.number";

    $queryConnection = connection("John", "John1")->prepare($sqlQuery);
    $queryConnection->execute();
    $orders = $queryConnection->fetchAll();
    return $orders;
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
    $orders = $queryConnection->fetchAll();
    return $orders;
}

function addingProduct($name, $price, $description, $weight, $url, $quantity, $availability, $categories_id, $discount)
{
    $sqlQuery =
        "INSERT INTO `products` (`name`, `price`, `description`, `weight`, `img_url`, `quantity`, `availability`, `categories_id`, `discount`)
        VALUES (:name, :price, :description, :weight, :url, :quantity, :availability, :categories_id, :discount)";

    $queryConnection = connection("John", "John1")->prepare($sqlQuery);
    $productAdded = $queryConnection->execute([
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
    return $productAdded;
}

function placeOrder($total, $shipping_cost, $total_weight, $customer_id, $carrier_id)
{
    $ordersQuery =
        "INSERT INTO `orders` (`total`, `shipping_cost`, `total_weight`, `customer_id`, `carrier_id`)
        VALUES (:total, :shipping_cost, :total_weight, :customer_id, :carrier_id)";

    $queryConnection = connection("John", "John1")->prepare($ordersQuery);
    $orderAdded = $queryConnection->execute([
        ':total' => $total,
        ':shipping_cost' => $shipping_cost,
        ':total_weight' => $total_weight,
        ':customer_id' => $customer_id,
        ':carrier_id' => $carrier_id
    ]);

    //
    $queryIdSelected = "SELECT MAX(id) FROM orders";
    $queryConnection2 = connection("John", "John1")->prepare($queryIdSelected);
    $queryConnection2->execute();
    $idSelected = $queryConnection2->fetchAll();
    placeOrerProduct(5, $total_weight, 1, $idSelected[0][0]);
    //

    return $orderAdded;

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
?>