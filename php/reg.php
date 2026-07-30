<?php

require_once "config.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['errors'] = [];

    $login = htmlspecialchars(trim($_POST["login"]));
    $pwd = htmlspecialchars(trim($_POST["pwd"]));
    $tel = htmlspecialchars(trim($_POST["tel"]));
    $name = htmlspecialchars(trim($_POST["name"]));
    $reppwd = htmlspecialchars(trim($_POST["reppwd"]));
    $role_id = 1;


    $_SESSION["reg-data"] = [
        "login" => $login,
        "pwd" => $pwd,
        "tel" => $tel,
        "name" => $name,
        "reppwd" => $reppwd
    ];


    if (empty($login) || empty($pwd) || empty($tel) || empty($name) || empty($_POST["reppwd"])) {
        $_SESSION['errors']["empty"] = "Заполните все поля";
    }
    if (!preg_match('/^[a-zA-Z0-9]{5,255}$/', $login)) {
        $_SESSION['errors']["login"] = "Логин должен содержать 5–255 символов: только английские буквы и цифры, без пробелов.";
    }
    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_\-+=\[\]{};:,.?\/<>|~`]).{8,20}$/', $pwd)) {
        $_SESSION['errors']["pwd"] = "Пароль должен быть от 8 до 20 символов и содержать минимум: 1 заглавную букву, 1 строчную букву, 1 цифру и 1 символ.";
    }
    if (!preg_match('/^[78][0-9]{10,19}$/', $tel)) {
        $_SESSION['errors']["tel"] = "Телефон должен начинаться с 7 или 8 и содержать от 11 до 20 цифр.";
    }

    if (!preg_match('/^[A-Za-zА-Яа-яЁё]{2,255}$/u', $name)) {
        $_SESSION['errors']["name"] = "Имя может содержать только русские и английские буквы, без пробелов. Длина: 2–255 символов.";
    }
    if ($pwd !== $_POST["reppwd"]) {
        $_SESSION['errors']["reppwd"] = "Пароли не совпадают";
    }



    $stmt = $mysqli->prepare("SELECT `id` FROM `users` WHERE `login` = ?");
    $stmt->bind_param("s", $login);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['errors']["unique-login"] = "Такой логин уже зарегистрирован";
    }

    $stmt = $mysqli->prepare("SELECT `id` FROM `users` WHERE `phone` = ?");
    $stmt->bind_param("s", $tel);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['errors']['unique-tel'] = "Этот номер телефона уже используется";
    }



    if (!empty($_SESSION['errors'])) {
        header("Location: ../register.php");
        exit;
    }
    
    $_SESSION["old-reg-data"]["pwd"] = $pwd;

    $pwd_hashed = password_hash($pwd, PASSWORD_DEFAULT);
    $stmt = $mysqli->prepare("
        INSERT INTO `users` (`login`, `password`, `phone`, `name`, `role_id`)
        VALUES (?, ?, ?, ?, ?)
    ");

    $stmt->bind_param("ssssi", $login, $pwd_hashed, $tel, $name, $role_id);
    if (!$stmt->execute()) {
        $_SESSION['errors']['db'] = "Ошибка базы данных: " . $stmt->error;
        header("Location: ../register.php");
        exit;
    }
    $_SESSION["success-reg"] = "Вы успено зарегистрировались!";
    $_SESSION["old-reg-data"]["phone"] = $tel;

    unset($_SESSION['reg-data']);
    unset($_SESSION['errors']);
    header("Location: ../auth.php");
    exit;
} else {
    echo "Подделка post запроса";
    exit;
}




