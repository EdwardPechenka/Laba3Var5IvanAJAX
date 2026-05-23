<?php
header('Content-Type: text/xml'); 
include "db.php";
$category_id = $_GET['category'] ?? '';

echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<root>';

$stmt = $pdo->prepare("SELECT name, price, quantity, quality FROM items WHERE FID_Category = ?");
$stmt->execute([$category_id]);

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo '<item>';
    echo '<name>' . htmlspecialchars($row['name']) . '</name>';
    echo '<price>' . htmlspecialchars($row['price']) . '</price>';
    echo '<quantity>' . htmlspecialchars($row['quantity']) . '</quantity>';
    echo '<quality>' . htmlspecialchars($row['quality']) . '</quality>';
    echo '</item>';
}
echo '</root>';
?>