<?php

session_start();

$mysqli = new mysqli("MySQL-8.0", "root", "", "db_bikes");

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
        orders.id as order_id
    FROM orders
    JOIN statuses ON statuses.id = orders.status_id
    JOIN products ON products.id = orders.product_id
    WHERE orders.user_id = ?
");


$stmt->bind_param("i", $_SESSION["user_id"]);
// $stmt->bind_param("i", $_GET["id"]);


$stmt->execute();
$res = $stmt->get_result();
$orders = $res->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$data = urlencode(json_encode($orders));
header("Location: ../../profile.php?orders=$data");
// echo "<pre>";
// print_r($orders);

