<?php
$type = $_GET['type'] ?? '';
header("Location: ../../catalog.php?type=" . urlencode($type));
exit;

?>