<?php

// Подключение к базе данных
require "lib/db.php";
?>

<?php require_once "blocks/header.php"; ?>
<div class="wrapper">
    <div class="container">
        <h1>Здесь можно добавлять, удалять и изменять категории</h1>
        <br><br>
        <a href="add-catalog.php" class="btn-primary">Добавить Категорию</a>
        <br><br>
        <table class="tbl-full">
            <tr>
                <th>S.N.</th>
                <th>Название</th>
                <th>Картина</th>
                <th>Действия</th>
            </tr>
            <?php  
            // Запрос для получения данных из БД
            $sql = "SELECT * FROM category";
            $query = $pdo->query($sql);
            $sn = 1;

            if ($query->rowCount() > 0) {
                while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                    $id = $row['id'];
                    $title = $row['title'];
                    $image = $row['image'];
                    ?>  
                    <tr>
                        <td><?php echo $sn++; ?></td>
                        <td><?php echo $title; ?></td>
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
                            <a href="edit-catalog.php?id=<?php echo $id; ?>" class="btn-secondary">Изменить</a>
                            <a href="delete-catalog.php?id=<?php echo $id; ?>" class="btn-danger">Удалить</a>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                echo '<tr><td colspan="4">Нет данных для отображения</td></tr>';
            }
            ?>
        </table>
    </div>
</div>


<style>
    h1 {
        text-align: center;
        color: #333;
        margin-bottom: 1.5rem;
    }

    .btn-primary, .btn-secondary, .btn-danger {
        display: inline-block;
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .btn-primary {
        background-color: #28a745;
        color: white;
    }

    .btn-primary:hover {
        background-color: #218838;
    }

    .btn-secondary {
        background-color: #007bff;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #0069d9;
    }

    .btn-danger {
        background-color: #dc3545;
        color: white;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }

    table.tbl-full {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    table.tbl-full th, table.tbl-full td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    table.tbl-full th {
        background-color: #f2f2f2;
        color: #333;
    }

    table.tbl-full tr:nth-of-type(even) {
        background-color: #f9f9f9;
    }

    table.tbl-full tr:hover {
        background-color: #f1f1f1;
    }

    table.tbl-full img {
        border-radius: 5px;
    }
</style>
<?php require_once "blocks/footer.php"; ?>