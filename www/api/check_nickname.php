<?php
require_once __DIR__ . '/../init.php';
header('Content-Type: application/json');
$nickname = trim($_GET['nickname'] ?? '');
$stmt = $db_connect->prepare('SELECT COUNT(*) FROM priv_info WHERE nickname = ?');
$stmt->execute([$nickname]);
$count = $stmt->fetchColumn();
echo json_encode(['exists' => $count]);
?>