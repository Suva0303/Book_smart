<?php
// отображение ошибок для отладки
ini_set('display_errors', 1);
error_reporting(E_ALL);

require "db.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $title = $_POST['title'];
    
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        // Путь для сохранения изображения
        $uploadDir = '../../images/catalog';
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
    
    $sql = 'INSERT INTO category (title, image) VALUES (?, ?)';
    $query = $pdo->prepare($sql);
    $query->execute([$title, $image]);
    
    header('Location: /admin/manage-catalog.php');
    exit;
}
?>
