<?php
require_once 'db.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $orderId = $_POST['order_id'];
    $status = $_POST['status'];

    try {
        $stmt = $pdo->prepare("UPDATE `order` SET `status` = ? WHERE `id` = ?");
        $stmt->execute([$status, $orderId]);

        header('Location: /admin/admin-order.php');
        exit;
    } catch (PDOException $e) {
        // Обработка ошибок обновления
        echo "Ошибка: " . $e->getMessage();
    }
}
?>
