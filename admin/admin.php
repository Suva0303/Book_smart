<?php
require_once "blocks/header.php";
?>

<div class="wrapper">
    <div class="container">
        <h1>Добро пожаловать в книжный магазин!</h1>
        <br><br>

        <div class="cards"> <!-- Перенесено сюда -->
            <?php
            // Подключение к базе данных
            require "lib/db.php";

            // Получение данных из таблицы `product`
            try {
                $stmt = $pdo->query("SELECT * FROM product");

                if ($stmt->rowCount() > 0) {
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        // Устанавливаем путь к изображению по умолчанию
                        $imagePath = "../../images/catalog/scale_1200.jpeg";
                        if (!empty($row['image'])) {
                            $imagePath = "../../images/catalog/" . htmlspecialchars($row['image'], ENT_QUOTES, 'UTF-8');
                        }
                        echo '
                        <div class="card">
                            <div class="card__top">
                                <a href="#" class="card__image"> <!-- Исправлено здесь -->
                                    <img width="100%" src="' . $imagePath . '" alt="Изображение">
                                </a>
                            </div>
                            <div class="card__bottom">
                                <div class="card__price">' . htmlspecialchars($row['price'], ENT_QUOTES, 'UTF-8') . ' руб.</div>
                                <div class="card__title">' . htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') . '</div>
                                <div class="card__title">Автор: ' . htmlspecialchars($row['author'], ENT_QUOTES, 'UTF-8') . '</div>
                                <div class="card__title">Страниц: ' . htmlspecialchars($row['pages'], ENT_QUOTES, 'UTF-8') . '</div>
                                <div class="card__title">Год: ' . htmlspecialchars($row['year'], ENT_QUOTES, 'UTF-8') . '</div>
                            </div>
                        </div>';
                    }
                } else {
                    echo "Нет данных для отображения";
                }
            } catch (PDOException $e) {
                echo "Ошибка при выполнении запроса: " . $e->getMessage();
            }
            ?>
        </div> <!-- Закрываем .cards -->

        <br><br>
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

                .card__label {
                    padding: 4px 8px;
                    position: absolute;
                    bottom: 10px;
                    left: 10px;
                    background: #ff6633;
                    border-radius: 4px;
                    font-weight: 400;
                    font-size: 16px;
                    color: #fff;
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

                .card__price::after {
                    content: "₽";
                    margin-left: 4px;
                    position: relative;
                }

                .card__price--discount {
                    font-weight: 700;
                    font-size: 19px;
                    color: #414141;
                    display: flex;
                    flex-wrap: wrap-reverse;
                }

                .card__price--discount::before {
                    content: "Со скидкой";
                    font-weight: 400;
                    font-size: 13px;
                    color: #bfbfbf;
                }

                .card__price--common {
                    font-weight: 400;
                    font-size: 17px;
                    color: #606060;
                    display: flex;
                    flex-wrap: wrap-reverse;
                    justify-content: flex-end;
                }

                .card__price--common::before {
                    content: "Обычная";
                    font-weight: 400;
                    font-size: 13px;
                    color: #bfbfbf;
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

                .card__add {
                    display: block;
                    width: 100%;
                    font-weight: 400;
                    font-size: 17px;
                    color: #70c05b;
                    padding: 10px;
                    text-align: center;
                    border: 1px solid #70c05b;
                    border-radius: 4px;
                    cursor: pointer;
                    transition: 0.2s;
                    margin-top: auto;
                }

                .card__add:hover {
                    border: 1px solid #ff6633;
                    background-color: #ff6633;
                    color: #fff;
                }
</style>  

<?php
require_once "blocks/footer.php";
?>
