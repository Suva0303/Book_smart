<?php require_once "blocks/header.php"; ?>
<?php

require_once 'lib/db.php'; 

// Предположим, что у нас есть идентификатор пользователя в сессии
session_start();
$user_id = $_SESSION['user_id'];

try {
    // Получение данных пользователя из базы данных
    $stmt = $pdo->prepare("SELECT login, username, profile_picture FROM user WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) {
        throw new Exception("Пользователь не найден.");
    }
} catch (Exception $e) {
    echo "Ошибка: " . $e->getMessage();
    die();
}

// Обработка загрузки нового фото профиля
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profile_picture'])) {
    $file = $_FILES['profile_picture']['tmp_name'];
    $imgData = file_get_contents($file);

    try {
        // Обновление фото профиля в базе данных
        $stmt = $pdo->prepare("UPDATE user SET profile_picture = ? WHERE id = ?");
        $stmt->bindParam(1, $imgData, PDO::PARAM_LOB);
        $stmt->bindParam(2, $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $user['profile_picture'] = $imgData; // Обновляем информацию в массиве пользователя
    } catch (PDOException $e) {
        echo "Ошибка: " . $e->getMessage();
    }
}
?>
<body>
    <div class="wrapper">
        <div class="feedback">
            <div class="container">
                <h2>Кабинет Пользователя</h2>
                <br><br>
                <div class="profile-container">
                    <div class="profile-info">
                        <div class="profile-picture">
                            <?php
                            if ($user['profile_picture']) {
                                $img = base64_encode($user['profile_picture']);
                                echo "<img src='data:image/jpeg;base64,$img' alt='Фото профиля'>";
                            } else {
                                echo "<img src='default_profile.png' alt='Фото профиля'>";
                            }
                            ?>
                        </div>
                        <div class="profile-details">
                            <p><strong>ФИО:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
                            <p><strong>Логин:</strong> <?php echo htmlspecialchars($user['login']); ?></p>
                        </div>
                    </div>
                    <div class="profile-edit">
                        <form method="POST" enctype="multipart/form-data">
                            <label for="profile_picture">Загрузить новое фото профиля:</label>
                            <input type="file" name="profile_picture" id="profile_picture" accept="image/*">
                            <input type="submit" value="Обновить фото">
                        </form>
                    </div>
                </div>
                <br><br>
                <form action="lib/logout.php" method="post">
                  <input type="submit" value="Выйти">
                </form>
                <br><br>
            </div>
        </div>
    </div>
</body>

<style>
        h2 {
            color: #333;
        }
        .profile-container {
            display: flex;
            align-items: center;
            justify-content: space-around;
            margin-top: 20px;
        }
        .profile-info, .profile-edit {
            flex: 1;
            max-width: 45%;
        }
        .profile-picture img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #ddd;
        }
        .profile-details {
            text-align: left;
            margin-top: 20px;
        }
        .profile-details p {
            margin: 5px 0;
            font-size: 18px;
        }
        .profile-edit form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .profile-edit input[type="file"] {
            margin-bottom: 15px;
        }
        .profile-edit input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }
        .profile-edit input[type="submit"]:hover {
            background-color: #45a049;
        }
        form[action="lib/logout.php"] input[type="submit"] {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }
        form[action="lib/logout.php"] input[type="submit"]:hover {
            background-color: #e53935;
        }
</style>
<?php require_once "blocks/footer.php"; ?>
