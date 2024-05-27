<?php
// Отоброжение ошибок для отладки
ini_set('display_errors', 1);
error_reporting(E_ALL);

require "db.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Получаем данные из формы
    $name = $_POST['name'];
    $category = $_POST['category'];
    $author = $_POST['author'];
    $pages = $_POST['pages'];
    $year = $_POST['year'];
    $price = $_POST['price'];
    
    // Проверяем и загружаем изображение
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        // Путь для сохранения изображения
        $uploadDir = '../../images/catalog/';
        $uploadFile = $uploadDir . basename($_FILES['image']['name']);
        
        // Перемещаем загруженный файл в нужную директорию
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            $image = $uploadFile;
        } else {
            echo "Ошибка загрузки изображения.";
            exit;
        }
    } else {
        $image = ''; // Путь к изображению по умолчанию, если файл не загружен
    }
    
    $sql = 'INSERT INTO product (name, image, category_id, author, pages, year, price) VALUES (?, ?, ?, ?, ?, ?, ?)';
    $query = $pdo->prepare($sql);
    $query->execute([$name, $image, $category, $author, $pages, $year, $price]);
    
    header('Location: /admin/manage-product.php');
    exit;
}
?>
