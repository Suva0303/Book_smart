<?php
session_start();
require_once "db.php";

// Проверяем, авторизован ли пользователь
if (isset($_SESSION['user_id'])) {
    // Пользователь авторизован, обрабатываем заказ
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $userId = $_SESSION['user_id'];
        $fullName = $_POST['full_name'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $address = $_POST['address'] ?? '';
        $deliveryDate = $_POST['delivery_date'] ?? '';

        try {
            // Подготовка и выполнение запроса на получение данных о товарах в корзине пользователя
            $stmtCart = $pdo->prepare("
                SELECT product_id, price, quantity
                FROM cart
                WHERE user_id = ?
            ");
            $stmtCart->execute([$userId]);

            // Проверяем, есть ли данные о товарах в корзине
            if ($stmtCart->rowCount() > 0) {
                // Проходимся по результатам запроса и вставляем данные о каждом товаре в таблицу заказа
                while ($row = $stmtCart->fetch(PDO::FETCH_ASSOC)) {
                    $productId = $row['product_id'];
                    $price = $row['price'];
                    $quantity = $row['quantity'];
                    
                    // Вставляем данные в таблицу заказа
                    $stmtOrder = $pdo->prepare("INSERT INTO `order` (user_id, product_id, full_name, phone, address, delivery_date, price, quantity) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmtOrder->execute([$userId, $productId, $fullName, $phone, $address, $deliveryDate, $price, $quantity]);
                }
                
                // Перенаправляем пользователя на страницу с информацией о заказе
                header('Location: /order-item.php');
                exit();
            } else {
                echo "<p>Ваша корзина пуста. Нельзя оформить заказ без товаров.</p>";
            }
        } catch (PDOException $e) {
            echo "Ошибка при оформлении заказа: " . $e->getMessage();
        }
    } else {
        echo "Некорректный запрос.";
    }
} else {
    // Пользователь не авторизован, выводим сообщение об ошибке
    echo "Ошибка: Требуется авторизация для оформления заказа.";
}
?>
