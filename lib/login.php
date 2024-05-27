<?php
session_start();

// Обрабатываем данные, полученные из формы регистрации
$login = trim(filter_var($_POST['login'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
$password = trim(filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));

if (strlen($login) < 4) {
    echo "Ошибка: логин слишком короткий";
    exit;
}

require "db.php";

// Авторизация пользователя
$sql = 'SELECT id FROM user WHERE login = ? AND password = ?';
$query = $pdo->prepare($sql);
$query->execute([$login, $password]);

if ($query->rowCount() == 0) {
    echo "Ошибка: такого пользователя нет";
} else {
    $user = $query->fetch(PDO::FETCH_ASSOC);
    $_SESSION['user_id'] = $user['id'];
    setcookie('login', $login, time() + 3600 * 24 * 30, "/");
    header('Location: /user.php');
}
?>
