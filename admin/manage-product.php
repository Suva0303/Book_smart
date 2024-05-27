<?php
// Подключение к базе данных
require "lib/db.php";
?>

<?php require_once "blocks/header.php"; ?>
<div class="wrapper">
    <div class="container">
        <h1>Здесь можно добавлять, удалять и изменять книги</h1>
        <br><br>
        <a href="add-product.php" class="btn-primary">Добавить книгу</a>
        <br><br>
        <table class="tbl-full">
            <tr>
                <th>S.N.</th>
                <th>Название</th>
                <th>Картина</th>
                <th>Жанр</th>
                <th>Автор</th>
                <th>Страниц</th>
                <th>Год</th>
                <th>Цена</th>
                <th>Действия</th>
            </tr>
            <?php  
            // Запрос для получения данных из БД
            $sql = "SELECT * FROM product";
            $query = $pdo->query($sql);
            $sn = 1;

            if ($query->rowCount() > 0) {
                while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                    $id = $row['id'];
                    $name = $row['name'];
                    $image = $row['image'];
                    $category = $row['category'];
                    $author = $row['author'];
                    $pages = $row['pages'];
                    $year = $row['year'];
                    $price = $row['price'];
                    ?>  
                    <tr>
                        <td><?php echo $sn++; ?></td>
                        <td><?php echo $name; ?></td>
                        <td>
                            <?php 
                            if ($image != "") {
                                ?>
                                <img src="../../images/catalog/<?php echo $image; ?>" width="100">
                                <?php
                            } else {
                                echo "Изображение не найдено";
                            }
                            ?>
                        </td>
                        <td>
                            <?php 
                            // Подключение к базе данных
                            require "lib/db.php";

                            try {
                                // Предположим, что вы имеете ID товара, который хотите проверить
                                $productId = $id; 

                                // Подготовка запроса для получения информации о категории товара
                                $stmt = $pdo->prepare("SELECT c.title AS category FROM product p INNER JOIN category c ON p.category_id = c.id WHERE p.id = :productId");
                                $stmt->execute(['productId' => $productId]);

                                // Проверяем, есть ли данные о категории товара
                                if ($stmt->rowCount() > 0) {
                                    // Получаем данные о категории товара
                                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                    $categoryTitle = htmlspecialchars($row['category'], ENT_QUOTES, 'UTF-8');
                                    echo $categoryTitle;
                                } else {
                                    // Если нет данных о категории товара
                                    echo 'Нет информации';
                                }
                            } catch (PDOException $e) {
                                // Выводим сообщение об ошибке, если что-то пошло не так с запросом к базе данных
                                echo "Ошибка: " . $e->getMessage();
                            }
                            ?>
                        </td>
                        <td><?php echo $author; ?></td>
                        <td><?php echo $pages; ?></td>
                        <td><?php echo $year; ?></td>
                        <td><?php echo $price; ?></td>
                        <td>
                            <a href="edit-product.php?id=<?php echo $id; ?>" class="btn-secondary">Изменить</a>
                            <a href="delete-product.php?id=<?php echo $id; ?>" class="btn-danger">Удалить</a>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                echo '<tr><td colspan="9">Нет данных для отображения</td></tr>';
            }
            ?>
        </table>
    </div>
</div>
<?php require_once "blocks/footer.php"; ?>

<style>
    h1 {
        text-align: center;
        color: #333;
        margin-bottom: 1.5rem;
    }

    a.btn-primary {
        display: inline-block;
        padding: 10px 20px;
        border-radius: 5px;
        background-color: #007bff;
        color: white;
        text-decoration: none;
        font-size: 1rem;
        transition: background-color 0.3s ease;
    }

    a.btn-primary:hover {
        background-color: #0056b3;
    }

    table.tbl-full {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    table.tbl-full th, table.tbl-full td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    table.tbl-full th {
        background-color: #f2f2f2;
        color: #333;
    }

    table.tbl-full tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    table.tbl-full img {
        max-width: 100px;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    a.btn-secondary, a.btn-danger {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 5px;
        text-decoration: none;
        font-size: 0.875rem;
        transition: background-color 0.3s ease;
    }

    a.btn-secondary {
        background-color: #007bff;
        color: white;
    }

    a.btn-secondary:hover {
        background-color: #0056b3;
    }

    a.btn-danger {
        background-color: #dc3545;
        color: white;
    }

    a.btn-danger:hover {
        background-color: #c82333;
    }
</style>
