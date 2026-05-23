<?php
header('Content-Type: application/json; charset=utf-8');
include "db.php";

$min_price = $_GET['min_price'] ?? 0;
$max_price = $_GET['max_price'] ?? 0;

$stmt = $pdo->prepare("SELECT name, price, quantity, quality FROM items WHERE price BETWEEN ? AND ?");
$stmt->execute([$min_price, $max_price]);

$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($rows, JSON_UNESCAPED_UNICODE); 
?>