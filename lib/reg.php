<?php 

    // Обрабатываем данные полученные из формы регистрации 
    $login = trim(filter_var($_POST['login'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $username = trim(filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $email = trim(filter_var($_POST['email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $password = trim(filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
   
    if (strlen($login)<4)
    {
        echo "login Error";
        exit;
    }
    
    require "db.php";    
    // Подготовка и выполнение запроса
    $sql = 'INSERT INTO user(login, username, email, password) VALUES(?, ?, ?, ?)';
    $query = $pdo->prepare($sql);
    $query->execute([$login, $username, $email, $password]);

    header('Location: /login.php')


?>