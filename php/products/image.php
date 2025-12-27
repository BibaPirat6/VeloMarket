<?php

$mysqli = new mysqli("MySQL-8.0", "root", "", "db_bikes");

$stmt = $mysqli->prepare("select `image` from `products` where `id`=?");
$stmt->bind_param("i", $_GET["id"]);
$stmt->execute();

$res = $stmt->get_result();
$data = $res->fetch_assoc();

$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime = $finfo->buffer($data["image"]);

header("Content-Type: $mime");

echo $data["image"];
?>