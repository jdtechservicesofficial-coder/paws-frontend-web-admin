<?php
$pdo = new PDO('mysql:host=127.0.0.1;dbname=pawandpaws;charset=utf8mb4', 'root', '12345678');
$stmt = $pdo->query("SELECT id, parent_id, name, status FROM product_categories LIMIT 10");
if ($stmt) {
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($rows, JSON_PRETTY_PRINT);
}
