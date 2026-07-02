<?php
// Подключаем конфиг с правильными данными для хостинга
require_once __DIR__ . '/../config.php';

// Проверяем ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Content-Type: image/svg+xml");
    echo '<svg xmlns="http://www.w3.org/2000/svg" width="200" height="200"><rect width="200" height="200" fill="#ccc"/><text x="30" y="120" font-size="20">ID не указан</text></svg>';
    exit;
}

$id = (int)$_GET['id'];

// Получаем изображение
$stmt = $mysqli->prepare("SELECT image FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$data = $res->fetch_assoc();

if (!$data || empty($data['image'])) {
    // Если изображения нет - возвращаем заглушку
    header("Content-Type: image/svg+xml");
    echo '<svg xmlns="http://www.w3.org/2000/svg" width="200" height="200"><rect width="200" height="200" fill="#eee"/><text x="40" y="120" font-size="18" fill="#999">Нет изображения</text></svg>';
    exit;
}

// Определяем MIME-тип
$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime = $finfo->buffer($data['image']);

// Если MIME не определился - ставим по умолчанию
if (!$mime || $mime === 'application/octet-stream') {
    $mime = 'image/jpeg';
}

header("Content-Type: $mime");
header("Content-Length: " . strlen($data['image']));
header("Cache-Control: public, max-age=86400");

echo $data['image'];
?>