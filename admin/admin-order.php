<?php require_once "blocks/header.php"; ?>
<?php
// Подключение к базе данных
require_once 'lib/db.php'; // Подключаем файл с настройками подключения

try {
    // Выполнение запроса для получения заказов
    $stmt = $pdo->query("SELECT * FROM `order`");

    // Доступные состояния заказа
    $statuses = ['в процессе', 'в пути', 'доставлен'];

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
                    <th>Действие</th>
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
                } elseif ($key === 'status') {
                    echo "<td>";
                    echo "<form method='POST' action='lib/update_status.php'>";
                    echo "<input type='hidden' name='order_id' value='{$row['id']}'>";
                    echo "<select name='status'>";
                    foreach ($statuses as $status) {
                        $selected = $status == $row['status'] ? "selected" : "";
                        echo "<option value='$status' $selected>$status</option>";
                    }
                    echo "</select>";
                    echo "</td>";
                } else {
                    echo "<td>$value</td>";
                }
            }
        }
        echo "<td><input type='submit' value='Изменить'></form></td>";
        echo "</tr>";
    }
    echo "</table>
        </div>"; // Перемещение закрывающего div тега
} catch (PDOException $e) {
    // Обработка ошибок подключения или выполнения запроса
    echo "Ошибка: " . $e->getMessage();
}
?>
<?php require_once "blocks/footer.php"; ?>
