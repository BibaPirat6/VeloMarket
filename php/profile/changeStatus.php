<?php

session_start();
require "../config.php";


if (empty($_SESSION["user_id"]) || $_SESSION["user_role"] !== "admin") {
    die("у тебя нету прав на это");
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Подделка пост запроса");
}

$status = htmlspecialchars(trim($_POST["status"]));
$order_id = htmlspecialchars(trim($_POST["order_id"]));

if (!preg_match('/^(approve|cancel|wait)$/', $status)) {
    die("подделка статуса");
}
if (!preg_match('/^\d+$/', $order_id)) {
    die("Некорректный ID заказа");
}

$statusMap = [
    "wait" => 1,
    "cancel" => 2,
    "approve" => 3
];

$status_id = $statusMap[$status];

$stmt = $mysqli->prepare("UPDATE orders set status_id = ? where id = ?");
$stmt->bind_param("ii", $status_id, $order_id);
$stmt->execute();

header("Location: ../../profile.php?page=orders");
exit;








