<?php
session_start();
require_once "db.php";

// Проверяем, был ли отправлен запрос POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Проверяем, что пользователь авторизован
    if (!isset($_SESSION['user_id'])) {
        echo "Ошибка: Пользователь не авторизован.";
        exit;
    }

    // Получаем ID пользователя из сессии
    $userId = $_SESSION['user_id'];

    // Проверяем, существуют ли необходимые параметры
    if (isset($_POST['product_id'])) {
        // Получаем ID товара из формы
        $productId = intval($_POST['product_id']);

        try {
            // Подготовка и выполнение запроса на удаление товара из корзины конкретного пользователя
            $stmt = $pdo->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
            $stmt->execute([$userId, $productId]);

            // Перенаправляем обратно на страницу корзины с параметром success
            header('Location: /cart.php?success=1');
            exit();
        } catch (PDOException $e) {
            echo "Ошибка при удалении товара из корзины: " . $e->getMessage();
        }
    } else {
        echo "Ошибка: Некорректные параметры запроса.";
    }
} else {
    echo "Ошибка: Некорректный запрос.";
}
?>
