<?php require_once "blocks/header.php"; ?>
<div class="wrapper">
    <div class="container">
        <h1>Добавить Книгу</h1>
        <br><br>
        <form action="lib/add-product.php" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Название</td>
                    <td>
                        <input type="text" name="name" placeholder="Название Книги" required>
                    </td>
                </tr>
                <tr>
                    <td>Выберите изображение</td>
                    <td>
                        <input type="file" name="image" required>
                    </td>
                </tr>
                <tr>
                    <td>Выберите категорию</td>
                    <td>
                        <select name="category" required>
                            <?php 
                            // Подключение к базе данных
                            require "lib/db.php";

                            // SQL-запрос для получения категорий
                            $sql = "SELECT * FROM category";
                            $stmt = $pdo->query($sql);

                            // Проверяем, есть ли категории
                            if ($stmt->rowCount() > 0) {
                                // Перебираем все записи и выводим их в выпадающий список
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $id = $row['id'];
                                    $title = htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8');
                                    echo "<option value=\"$id\">$title</option>";
                                }
                            } else {
                                // Если категорий нет
                                echo '<option value="0">Нет категории</option>';
                            }
                            ?>    
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Введите Автора:</td>
                    <td>
                        <input type="text" name="author" required>
                    </td>
                </tr>
                <tr>
                    <td>Введите количество страниц:</td>
                    <td>
                        <input type="number" name="pages" required>
                    </td>
                </tr>
                <tr>
                    <td>Введите год издания:</td>
                    <td>
                        <input type="number" name="year" min="0" max="2100" required>
                    </td>
                </tr>
                <tr>
                    <td>Введите Цену:</td>
                    <td>
                        <input type="number" name="price" step="0.01" required>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" value="Добавить книгу" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
<?php require_once "blocks/footer.php"; ?>

<style>
    h1 {
        text-align: center;
        color: #333;
        margin-bottom: 1.5rem;
    }

    table.tbl-30 {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    table.tbl-30 td {
        padding: 10px;
        vertical-align: middle;
    }

    table.tbl-30 td:first-child {
        width: 30%;
        font-weight: bold;
        color: #555;
    }

    table.tbl-30 td:last-child {
        width: 70%;
    }

    input[type="text"],
    input[type="file"],
    select,
    input[type="number"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
        font-size: 1rem;
        margin-top: 0.5rem;
    }

    input[type="submit"] {
        width: 100%;
        padding: 10px;
        border: none;
        border-radius: 5px;
        background-color: #007bff;
        color: white;
        font-size: 1rem;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    input[type="submit"]:hover {
        background-color: #0056b3;
    }

    .btn-secondary {
        background-color: #007bff;
    }
</style>
