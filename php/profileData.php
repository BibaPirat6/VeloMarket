<?php
require_once "config.php";
session_start();

if (empty($_SESSION["user_role"]) || empty($_SESSION["user_id"])) {
    header("Location: ./register.php");
    exit;
}

$stmt = $mysqli->prepare("select * from `users` where `id`=?");
$stmt->bind_param("i", $_SESSION["user_id"]);
$stmt->execute();

$res = $stmt->get_result();
$data = $res->fetch_assoc();

?>