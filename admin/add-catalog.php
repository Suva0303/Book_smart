<?php require_once "blocks/header.php"; ?>
<div class="wrapper">
    <div class="container">
        <h1>Добавить Категорию</h1>
        <br><br>
        <form action="lib/add-catalog.php" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Название</td>
                    <td>
                        <input type="text" name="title" placeholder="Название категории">
                    </td>
                </tr>
                <tr>
                    <td>Выберите изображение</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" value="Добавить категорию" class="btn-secondary">
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

    table {
        width: 100%;
        border-collapse: collapse;
    }

    td {
        padding: 0.5rem 0;
        vertical-align: middle;
    }

    input[type="text"], input[type="file"] {
        width: 100%;
        padding: 0.5rem;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
        font-size: 1rem;
        margin-top: 0.5rem;
    }

    input[type="file"] {
        padding: 0.25rem;
    }

    input[type="submit"] {
        width: 100%;
        padding: 0.75rem;
        border: none;
        border-radius: 5px;
        background-color: #48f;
        color: white;
        font-size: 1rem;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    input[type="submit"]:hover {
        background-color: #3478e5;
    }

    .btn-secondary {
        background-color: #48f;
    }
</style>
