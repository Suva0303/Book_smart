<?php
session_start();

// Проверяем, установлена ли сессия пользователя
if (!isset($_SESSION['user_id'])) {
    // Если сессия не установлена, перенаправляем пользователя на страницу авторизации
    header('Location: /login.php');
    exit();
}

// Если сессия установлена, пользователь авторизован
require_once "blocks/header.php";
require_once 'lib/db.php'; 

// Получение идентификатора текущего пользователя из сессии
$user_id = $_SESSION['user_id'];

try {
    // Выполнение запроса на получение заказов текущего пользователя
    $stmt = $pdo->prepare("SELECT * FROM `order` WHERE user_id = ?");
    $stmt->execute([$user_id]);

    // Создание HTML таблицы и ее заголовка (без столбца id)
    echo "
        <div class='wrapper'>
            <table border='1'>
                <tr>
                    <th>Номер заказа</th>
                    <th>Получатель:</th>
                    <th>Тел:</th>
                    <th>Адрес</th>
                    <th>Дата Доставки:</th>
                    <th>Состояние:</th>
                    <th>Дата заказа</th>
                    <th>Название товара:</th>
                    <th>Стоимость</th>
                    <th>Количество</th>
                </tr>";

    // Получение результатов запроса и вывод строк таблицы (без столбца id)
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        // Пропускаем вывод столбца id
        foreach ($row as $key => $value) {
            if ($key !== 'id') {
                if ($key === 'price') {
                    // Вычисляем общую стоимость: количество * стоимость
                    $total_price = $row['quantity'] * $row['price'];
                    echo "<td>$total_price</td>";
                } else {
                    echo "<td>$value</td>";
                }
            }
        }
        echo "</tr>";
    }
    echo "</table>
        </div>"; 
} catch (PDOException $e) {

    echo "Ошибка: " . $e->getMessage();
}

require_once "blocks/footer.php";
?>
