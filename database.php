<?php function connection($user, $password): PDO
{
    try {
        // On se connecte à MySQL
        $mysqlClient = new PDO('mysql:host=localhost;dbname=store;charset=utf8', "$user", "$password");
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
    } return $name;
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

function placeOrder($total, $date, $weight)
{
    $ordersQuery =
        "INSERT INTO `orders` (`number`, `total`, `date`, `shipping cost`, `total_weight`, `customerid`, `carrier_id`, `status`)
        VALUES ('4500014', :total , :date , 5, :weight , 1 , 1 , 'actif')";

    $queryConnection = connection("John", "John1")->prepare($ordersQuery);
    $orderAdding = $queryConnection->execute([
        ':total' => $total,
        ':date' => $date,
        ':weight' => $weight
    ]);
    return $orderAdding;
}
?>