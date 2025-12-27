<?php

require_once "config.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION["user_role"] == "admin") {

    $_SESSION["add_product_errors"] = [];

    $name = htmlspecialchars(trim($_POST["name"]));
    $img = $_FILES["img"];
    $price = htmlspecialchars(trim($_POST["price"]));
    $type = htmlspecialchars(trim($_POST["type"]));

    if (empty($name) || empty($price) || empty($type)) {
        $_SESSION['add_product_errors']["empty"] = "Заполните все поля";
    }
    if (!isset($_FILES['img']) || $_FILES['img']['error'] === UPLOAD_ERR_NO_FILE) {
        $_SESSION['add_product_errors']['img'] = 'Вы не выбрали изображение';
    }
    if (!preg_match("/^[a-zA-Zа-яА-ЯёЁ0-9 ]+$/u", $name)) {
        $_SESSION['add_product_errors']["name"] = "Название может содержать только буквы, цифры и пробелы";
    }
    if (!preg_match('/^(?:[5-9]\d|[1-9]\d{2}|[1-9]\d{3}|10000)$/', $price)) {
        $_SESSION["add_product_errors"]["price"] = "Цена должна быть от 50 до 10000";
    }
    if (!preg_match('/^(city|electro|family|speed)$/', $type)) {
        $_SESSION["add_product_errors"]["type"] = "Некорректный тип велосипеда";
    }

    if (!empty($_SESSION['add_product_errors'])) {
        header("Location: ../catalog.php?type=all");
        exit;
    }


    $imageData = file_get_contents($img["tmp_name"]);
    $stmt = $mysqli->prepare("
    INSERT INTO `products` (`title`, `image`, `price_per_hour`, `type`)
    VALUES (?, ?, ?, ?)
    ");
    $stmt->bind_param("ssis", $name, $imageData, $price, $type);
    $stmt->execute();
    $stmt->close();

    $_SESSION["add_product_success"] = "Велосипед успешно добавлен";
    unset($_SESSION["add_product_errors"]);
    header("Location: ../catalog.php?type=all");
    exit;

} else {
    echo "Подделка post запроса";
    exit;
}




