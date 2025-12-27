<?php

require_once "config.php";
if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    die("Ты поделал get запрос мальчик");
}

$type = $_GET['type'] ?? null;

if ($type) {
    $stmt = $mysqli->prepare("SELECT * FROM `products` WHERE `type`=?");
    $stmt->bind_param("s", $type);
} else {
    $stmt = $mysqli->prepare("SELECT * FROM `products`");
}

$stmt->execute();
$res = $stmt->get_result();
$products_filter = $res->fetch_all(MYSQLI_ASSOC);
$stmt->close();