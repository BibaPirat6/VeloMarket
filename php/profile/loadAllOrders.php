<?php
session_start();
// require_once "../config.php";   

if (empty($_SESSION["user_id"])) {
    die("У тебя нету id");
}


$stmt = $mysqli->prepare("SELECT 
        orders.start_datetime, 
        orders.end_datetime, 
        orders.product_id,
        statuses.name,
        products.title,
        products.price_per_hour,
        users.login,
        users.phone,
        users.name as user_name,
        orders.id as order_id
    FROM orders
    JOIN statuses ON statuses.id = orders.status_id
    JOIN products ON products.id = orders.product_id
    JOIN users ON users.id = orders.user_id
");
$stmt->execute();
$res = $stmt->get_result();
$orders = $res->fetch_all(MYSQLI_ASSOC);
$stmt->close();

?>