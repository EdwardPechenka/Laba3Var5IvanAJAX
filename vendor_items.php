<?php
include "db.php";
$vendor_id = $_GET['vendor'] ?? '';

$stmt = $pdo->prepare("SELECT name, price, quantity, quality FROM items WHERE FID_Vendor = ?");
$stmt->execute([$vendor_id]);

echo "<h3>Товари виробника (формат Text)</h3><ul>";
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<li><b>{$row['name']}</b> — Ціна: {$row['price']} грн, Кількість: {$row['quantity']} шт, Якість: {$row['quality']}/5</li>";
}
echo "</ul>";
?>