<?php

require_once "config.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION["user_role"] === "user") {

    $_SESSION["create_order_errors"] = [];

    $user_id = $_SESSION["user_id"];
    $product_id = htmlspecialchars(trim($_POST["product_id"]));
    $status_id = 1;
    $start_date = date("Y-m-d");
    $end_date = htmlspecialchars(trim($_POST["date"]));


    if (empty($user_id) || empty($product_id) || empty($end_date)) {
        $_SESSION["create_order_errors"]["empty"] = "Вы не заполнили поле";
    }
    if ($start_date > $end_date) {
        $_SESSION["create_order_errors"]["date"] = "Дата окончания аренды не может быть раньше сегодняшнего числа";
    }
    $max_date = date("Y-m-d", strtotime("+1 month"));
    if ($end_date > $max_date) {
        $_SESSION["create_order_errors"]["max"] = "Нельзя выбрать дату больше чем на 1 месяц вперёд!";
    }

    if (!empty($_SESSION['create_order_errors'])) {
        header("Location: ../rent.php?id=" . $product_id);
        exit;
    }

    $stmt = $mysqli->prepare("SELECT `price_per_hour` from `products` where `id`=?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $price = $res->fetch_assoc()["price_per_hour"];

    $stmt = $mysqli->prepare("INSERT into `orders` (`user_id`,`product_id`,`status_id`,`price`,`start_datetime`,`end_datetime`) value (?, ?, ?,?,?,?)");
    $stmt->bind_param("iiiiss", $user_id, $product_id, $status_id, $price, $start_date, $end_date);
    $stmt->execute();
    $stmt->close();


    $_SESSION["success_create_order"] = "Вы успешно арендовали велосипед";
    header("Location: ../catalog.php?type=all");
    unset($_SESSION["create_order_errors"]);
    exit;
} else {
    echo "Подделка post запроса или ты не пользователь";
    exit;
}




