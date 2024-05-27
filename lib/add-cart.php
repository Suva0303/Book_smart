<?php
session_start();
require "db.php"; 
// Включаем отображение ошибок для отладки
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Проверяем, что данные были отправлены и пользователь авторизован
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    // Получаем данные из формы
    $userId = $_SESSION['user_id'];
    $productId = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);

    // Проверяем количество и устанавливаем его значение по умолчанию как 1, если не установлено
    if ($quantity <= 0) {
        $quantity = 1;
    }

    try {
        // Получаем цену продукта
        $stmt = $pdo->prepare("SELECT price FROM product WHERE id = :product_id");
        $stmt->execute([':product_id' => $productId]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            $price = $product['price'];

            // Подготовка и выполнение запроса на добавление товара в корзину
            $stmt = $pdo->prepare("INSERT INTO cart (user_id, product_id, quantity, added_at, price) VALUES (:user_id, :product_id, :quantity, NOW(), :price)");
            $stmt->execute([
                ':user_id' => $userId,
                ':product_id' => $productId,
                ':quantity' => $quantity,
                ':price' => $price
            ]);

            echo "Товар успешно добавлен в корзину!";
            header('Location: /cart.php');
            exit(); 
        } else {
            echo "Ошибка: продукт не найден.";
        }
    } catch (PDOException $e) {
        echo "Ошибка при добавлении товара в корзину: " . $e->getMessage();
    }
} else {
    echo "Ошибка: пожалуйста, войдите в систему, чтобы добавить товары в корзину.";
}
?>
