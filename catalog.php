<?php require_once "blocks/header.php"; ?>
<div class="wrapper">
    <div class="container">
        <h1>Каталог Книг</h1>
        <?php

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        // Подключение к базе данных
        require "lib/db.php";

        try {
            // Подготовка запроса для получения данных
            $stmt = $pdo->query("SELECT * FROM category");

            // Проверяем, есть ли данные
            if ($stmt->rowCount() > 0) {
                echo '<div class="cards">';
                // Перебираем результаты запроса
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    // Устанавливаем путь к изображению по умолчанию
                    $imagePath = "../../images/catalog/scale_1200.jpeg";

                    // Если изображение существует, используем его путь
                    if (!empty($row['image'])) {
                        $imagePath = "../../images/catalog/" . $row['image'];
                    }

                    // Выводим тег <img> с путем к изображению
                    echo '
                        <div class="card">
                            <div class="card__top">
                                <a href="catalog_content.php?category_id=' . $row['id'] . '" class="card__image">
                                    <img width="100%" src="' . $imagePath . '" alt="Изображение">
                                </a>
                            </div>
                            <div class="card__bottom"> 
                                <div class="card__title">' . htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8') . '</div>
                            </div>
                            <a href="catalog_content.php?category_id=' . $row['id'] . '" class="card__add">Перейти</a>
                        </div>';
                }
                echo '</div>';
            } else {
                // Если данных нет
                echo "Нет данных для отображения";
            }
        } catch (PDOException $e) {
            // Выводим сообщение об ошибке, если что-то пошло не так с запросом к базе данных
            echo "Ошибка при выполнении запроса: " . $e->getMessage();
        }
        ?>
    </div>
</div>

<style>
    .cards {
        display: grid;
        grid-template-columns: repeat(auto-fill, 225px);
        width: 100%;
        max-width: 1000px;
        justify-content: center;
        justify-items: center;
        column-gap: 30px;
        row-gap: 40px;
        margin: 5% auto;
    }

    .card {
        width: 225px;
        min-height: 350px;
        box-shadow: 1px 2px 4px rgba(0, 0, 0, 0.8);
        display: flex;
        flex-direction: column;
        border-radius: 4px;
        transition: 0.2s;
        position: relative;
    }

    .card:hover {
        box-shadow: 4px 8px 16px rgba(255, 102, 51, 0.2);
    }

    .card__top {
        flex: 0 0 220px;
        position: relative;
        overflow: hidden;
    }

    .card__image {
        display: block;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }

    .card__image > img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        transition: 0.2s;
    }

    .card__image:hover > img {
        transform: scale(1.1);
    }

    .card__bottom {
        display: flex;
        flex-direction: column;
        flex: 1 0 auto;
        padding: 10px;
    }

    .card__prices {
        display: flex;
        margin-bottom: 10px;
        flex: 0 0 50%;
    }

    .card__title {
        display: block;
        margin-bottom: 10px;
        font-weight: 400;
        font-size: 17px;
        line-height: 150%;
        color: #414141;
    }

    .card__title:hover {
        color: #ff6633;
    }

    /* Медиазапросы */
    @media (max-width: 1200px) {
        .cards {
            grid-template-columns: repeat(auto-fill, 200px);
            column-gap: 20px;
            row-gap: 30px;
        }

        .card {
            width: 200px;
            min-height: 300px;
        }
    }

    @media (max-width: 750px) {
        .cards {
            grid-template-columns: repeat(auto-fill, 150px);
            column-gap: 15px;
            row-gap: 25px;
        }

        .card {
            width: 150px;
            min-height: 250px;
        }
    }

    @media (max-width: 480px) {
        .cards {
            grid-template-columns: 1fr;
            column-gap: 10px;
            row-gap: 20px;
        }

        .card {
            width: 100%;
            min-height: 200px;
        }
    }
</style>

<?php require_once "blocks/footer.php"; ?>
