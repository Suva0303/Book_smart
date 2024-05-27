

<body>
<?php require_once "blocks/header.php"; ?>

    <div class="feedback">
        <div class="container-login">
            <h2>Регистрация</h2>
            <form method="post" action="lib/reg.php">
                <div class="inline">
                    <div>
                        <label>Логин</label>
                        <input type="text" name="login">
                    </div>
                    <div>
                        <label>ФИО</label>
                        <input type="text" name="username">
                    </div>

                    <div>
                        <label>Email</label>
                        <input type="email" class="one-line" name="email">
                    </div>

                    <div>
                        <label>Пароль</label>
                        <input type="password" class="one-line" name="password">    
                    </div>

                </div>
                <br><br>

                <button type="submit">Зарегестрироваться</button>
                <br><br>
            </form>
        </div>
    </div>

    <?php require_once "blocks/footer.php"; ?>

</body>

</html>