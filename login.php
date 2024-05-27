

<body>
<?php require_once "blocks/header.php"; ?>

    <div class="feedback">
        <div class="container-login">
            <h2>Авторизация</h2>
            <form method="post" action="lib/login.php">
                <div class="inline">
                    <div>
                        <label>Логин</label>
                        <input type="text" name="login">
                    </div>
                    <div>
                        <label>Пароль</label>
                        <input type="password"  name="password">
                    </div>
                </div>    

                <br><br>
                <button type="submit">Войти</button>
            </form>
        </div>
    </div>

    <?php require_once "blocks/footer.php"; ?>

</body>

</html>