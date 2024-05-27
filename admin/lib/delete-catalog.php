<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require "db.php";

// Проверяем, был ли передан параметр 'id'
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    // Получаем id для удаления
    $id = $_GET['id'];

    // Подготавливаем SQL-запрос для удаления записи
    $sql = "DELETE FROM category WHERE id = ?";

    // Выполняем запрос
    $query = $pdo->prepare($sql);
    $query->execute([$id]);

    // Проверяем, была ли удалена запись
    if ($query->rowCount() > 0) {
        echo "Запись с ID $id успешно удалена.";
    } else {
        echo "Запись с ID $id не была найдена или не удалена.";
    }

    header("Location: manage-catalog.php");
    exit; 
} else {
    echo "ID записи для удаления не был передан или является недопустимым.";
}
?>
