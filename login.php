<?php
require_once('helpers.php'); //Подключаем файлы
require_once('mysqli_connect.php');
require_once('categories.php');
require_once('user.php');
date_default_timezone_set('Asia/Novosibirsk');

$errors_login = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Удаляет теги из email
        if (isset($_POST['email'])) {
            strip_tags($_POST['email']);
        }

    //Проверка полей на пустоту
    $required_fields = ['email', 'password'];
    foreach ($required_fields as $field) {  //Обязательные поля
        if (empty($_POST[$field])) {
            $errors_login[$field] = 'Поле не заполнено';
        }
    }

    //Проверка email и password
    if (!count($errors_login)) {
        $sql = 'SELECT *  FROM users WHERE email = ?';
        $result_valid_email = db_fetch_data($mysqli_connect, $sql, [$_POST['email']]);
        var_dump($result_valid_email);
        if ($result_valid_email[0]['email'] !== $_POST['email']) {
            $errors_login['password'] = 'Не верный логин или пароль';
            $errors_login['email'] = 'Не верный логин или пароль';
        }
        if (!password_verify($_POST['password'], $_POST['password'])) {
            $errors_login['password'] = 'Не верный логин или пароль';
            $errors_login['email'] = 'Не верный логин или пароль';
        }
    }

    //Усли валидация пошла успешно
    if (!count($errors_login)) {
        $user = $result_valid_email[0]['user_name'];
        $_SESSION['user'] = $user;

        header("Location: index.php");
        exit();
    }
}

// Подключение шаблонов
$login_content = include_template('login.php', [
    'errors_login' => $errors_login
]);

$layout_content = include_template('layout.php', [
    'content' => $login_content,
    'categories' => $categories,
    'title' => 'Вход',
   // 'user_name' => $user_name,
   // 'is_auth' => $is_auth      //Рандомная функция
]);
print($layout_content);
