<?php require_once "blocks/header.php"; ?>

<form action="lib/order-processing.php" method="post">
<div class="wrapper">
    <div class="container">
        <h1>Оформление заказа</h1>
            <label for="full_name">ФИО:</label>
            <input type="text" name="full_name" id="full_name" required><br><br>

            <label for="phone">Телефон:</label>
            <input type="tel" name="phone" id="phone" required><br><br>

            <label for="address">Адрес доставки:</label>
            <input type="text" name="address" id="address" required><br><br>

            <label for="delivery_date">Дата доставки:</label>
            <input type="date" name="delivery_date" id="delivery_date" required><br><br>
            
            <!-- Добавляем скрытое поле для передачи product_id -->
            <input type="hidden" name="product_id" value="<?php echo $productId; ?>">

            <input type="submit" value="Заказать">
    </div>
</div>

</form>


<?php require_once "blocks/footer.php"; ?>
