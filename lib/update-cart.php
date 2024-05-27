<?php
session_start();
require "db.php"; 


if (!isset($_SESSION['user_id'])) {
    echo "Ошибка: Пользователь не авторизован.";
    exit;
}

// Проверяем, был ли отправлен запрос POST и существуют ли необходимые параметры
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cart_id']) && isset($_POST['quantity'])) {
    // Получаем ID пользователя из сессии
    $userId = $_SESSION['user_id'];
    // Получаем ID записи корзины из формы
    $cartId = intval($_POST['cart_id']);
    // Получаем количество товара из формы
    $quantity = intval($_POST['quantity']);

    try {
        // Подготовка и выполнение запроса на обновление количества товара в корзине
        $stmt = $pdo->prepare("UPDATE cart SET quantity = :quantity WHERE user_id = :user_id AND id = :cart_id");
        $stmt->execute([
            ':quantity' => $quantity,
            ':user_id' => $userId,
            ':cart_id' => $cartId
        ]);

        // Перенаправляем обратно на страницу корзины
        header('Location: /cart.php');
        exit();
    } catch (PDOException $e) {
        echo "Ошибка при обновлении количества товара в корзине: " . $e->getMessage();
    }
} else {
    echo "Ошибка: Некорректный запрос.";
}
?>
