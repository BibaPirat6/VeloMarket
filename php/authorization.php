<?php
require_once "config.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['errors_auth'] = [];
    $tel = htmlspecialchars(trim($_POST["tel"]));
    $pwd = htmlspecialchars(trim($_POST["pwd"]));
    $_SESSION["auth_data"] = [
        "tel" => $tel,
        "pwd" => $pwd
    ];

    if ($tel != "admin") {
        if (empty($tel) || empty($pwd)) {
            $_SESSION['errors_auth']["empty"] = "Заполните все поля";
        }
        if (!preg_match('/^[78][0-9]{10,19}$/', $tel)) {
            $_SESSION['errors_auth']["tel"] = "Телефон должен начинаться с 7 или 8 и содержать от 11 до 20 цифр.";
        }
    }

    $stmt = $mysqli->prepare("SELECT * FROM `users` WHERE `phone` = ?");
    $stmt->bind_param("s", $tel);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($tel != "admin") {
        if (!$user || !password_verify($pwd, $user['password'])) {
            $_SESSION['errors_auth']["login_or_pwd"] = "Неверный телефон или пароль";
        }
    }

    if (!empty($_SESSION['errors_auth'])) {
        header("Location: ../auth.php");
        exit;
    }


    $_SESSION['user_id'] = $user['id'];
    $stmt = $mysqli->prepare("select `name` from `roles` where `id`=?");
    $stmt->bind_param("i", $user['role_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $role = $result->fetch_assoc();
    $_SESSION['user_role'] = $role["name"];

    $_SESSION["success-auth"] = "Вы успешно вошли в аккаунт!";


    unset($_SESSION['auth_data']);
    unset($_SESSION['errors_auth']);
    unset($_SESSION["old-reg-data"]);
    if ($_SESSION["user_role"] === "admin") {
        header("Location: ../profile.php?page=orders");
    } else {
        header("Location: ../profile.php");
    }
    exit;
} else {
    echo "Подделка post запроса";
    exit;
}


?>