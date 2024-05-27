<?php require_once "blocks/header.php"; ?>
<?php
session_start();
require "lib/db.php";

if (isset($_GET['success']) && $_GET['success'] == 1) {
    echo ' <div class="wrapper"><div class="notification">Товар успешно удален из корзины!</div></div> ';
}

ini_set('display_errors', 1);
error_reporting(E_ALL);

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $totalPrice = 0; // Переменная для общей стоимости

    try {
        $stmt = $pdo->prepare("
            SELECT cart.id, cart.product_id, cart.quantity, cart.price, product.name, product.author, product.pages, product.year, product.image 
            FROM cart 
            JOIN product ON cart.product_id = product.id 
            WHERE cart.user_id = :user_id
        ");
        $stmt->execute([':user_id' => $userId]);

        if ($stmt->rowCount() > 0) {
            echo '<div class="cart-items">';
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $imagePath = "../../images/catalog/scale_1200.jpeg";
                if (!empty($row['image'])) {
                    $imagePath = "../../images/catalog/" . htmlspecialchars($row['image'], ENT_QUOTES, 'UTF-8');
                }
                $itemTotal = $row['price'] * $row['quantity'];
                $totalPrice += $itemTotal; // Добавляем стоимость товара к общей стоимости
                
                echo '
                    <div class="wrapper">
                        <div class="container">
                            <div class="cart-item">
                                <img src="' . $imagePath . '" alt="' . htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') . '">
                                <div class="cart-item-details">
                                    <div class="cart-item-name">' . htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') . '</div>
                                    <div class="cart-item-quantity">
                                        <form method="POST" action="lib/update-cart.php"> 
                                            <input type="hidden" name="cart_id" value="' . $row['id'] . '">
                                            <input type="number" name="quantity" value="' . $row['quantity'] . '" min="1">
                                            <button type="submit">Обновить</button>
                                        </form>
                                        <form method="POST" action="lib/delete-cart.php"> 
                                                <input type="hidden" name="user_id" value="' . $userId . '"> 
                                                <input type="hidden" name="product_id" value="' . $row['product_id'] . '"> 
                                                <button type="submit">Удалить товар</button>
                                        </form>
                                    </div>
                                    <div class="cart-item-price">Цена: ' . htmlspecialchars($row['price'], ENT_QUOTES, 'UTF-8') . ' руб.</div>
                                    <div class="cart-item-author">Автор: ' . htmlspecialchars($row['author'], ENT_QUOTES, 'UTF-8') . '</div>
                                    <div class="cart-item-pages">Страниц: ' . htmlspecialchars($row['pages'], ENT_QUOTES, 'UTF-8') . '</div>
                                    <div class="cart-item-year">Год: ' . htmlspecialchars($row['year'], ENT_QUOTES, 'UTF-8') . '</div>
                                    <div class="cart-item-total">Итого за товар: ' . htmlspecialchars($itemTotal, ENT_QUOTES, 'UTF-8') . ' руб.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                ';
            }
            echo '</div>';
            echo '
                <div class="wrapper">
                    <div class="total-price">
                        Общая стоимость: ' . htmlspecialchars($totalPrice, ENT_QUOTES, 'UTF-8') . ' руб.
                    </div>
                    <form action="order.php" method="get">
                        <div class="order-button">
                            <button type="submit" class="order-link">Оформить заказ</button>
                        </div>
                    </form>
                </div>
            ';
        } else {
            echo " <div class='wrapper'><p>Ваша корзина пуста.</p></div> ";
        }
    } catch (PDOException $e) {
        echo "<p>Ошибка при выполнении запроса: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p>Пожалуйста, войдите в систему, чтобы увидеть содержимое корзины.</p>";
}
?>

<style>
    .cart-items {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
    .cart-item {
        display: flex;
        gap: 20px;
        border: 1px solid #ccc;
        padding: 10px;
        border-radius: 5px;
    }
    .cart-item img {
        width: 100px;
        height: 150px;
        object-fit: cover;
    }
    .cart-item-details {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .cart-item-name,
    .cart-item-quantity,
    .cart-item-price,
    .cart-item-author,
    .cart-item-pages,
    .cart-item-year {
        font-size: 16px;
    }
    .notification {
        background-color: #4CAF50;
        color: white;
        text-align: center;
        padding: 10px;
        margin-bottom: 20px;
    }
    .total-price {
        font-size: 20px;
        font-weight: 600;
        margin-top: 20px;
        text-align: center;
        color: #333;
    }

</style>

<?php require_once "blocks/footer.php"; ?>