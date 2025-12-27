<?php
session_start();
// require_once "../config.php";

if (empty($_SESSION["user_id"])) {
    die("У тебя нету id");
}


$stmt = $mysqli->prepare("SELECT * from `users`");
$stmt->execute();
$res = $stmt->get_result();
$users = $res->fetch_all(MYSQLI_ASSOC);
$stmt->close();


?>