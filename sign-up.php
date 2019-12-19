<?php
require_once('helpers.php'); //Подключаем файлы
require_once('mysqli_connect.php');
require_once('categories.php');
require_once('user.php');
date_default_timezone_set('Asia/Novosibirsk');

//Если залогиненый, то 404(
if (isset($_SESSION['user'])) {
    header("HTTP/1.0 404 Not Found");//Было написано по-другому
    die;
}

$errors_sign_up = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Удаляет теги
    $strip_tags_fields = ['email', 'name', 'message'];
    foreach ($strip_tags_fields as $field) {
        if (isset($_POST[$field])) {
            $_POST[$field] = strip_tags($_POST[$field]);
        }
    }
    //Проверка на пустоту
    $required_fields = ['email', 'password', 'name', 'message'];
    foreach ($required_fields as $field) {  //Обязательные поля
        if (empty($_POST[$field])) {
            $errors_sign_up[$field] = 'Поле не заполнено';
        }
    }
    //Проверка email
    $filter_var = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    if (!$filter_var) {
        $errors_sign_up['email'] = "Не корректный email";
    } else {
        $sql_email = "SELECT email FROM users WHERE email = '{$_POST['email']}'";// Собственно сам запрос
        $result_email = mysqli_query($mysqli_connect, $sql_email);// Сначала получаем объект результата
        if ($result_email) {
            $row = mysqli_fetch_assoc($result_email);// Затем преобразуем объект результата в виде ассоциативного массива
        } else {
            show_error($mysqli_connect);
        }
    }
    if (!empty($row)) {
        $errors_sign_up['email'] = 'email уже существует';
    }
    //Проверка пароля
    $str = isCorrectLength('password', 6, 30);
    if (!empty($str)) {
        $errors_sign_up['password'] = $str;
    }
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    if (empty($errors_sign_up)) {
        $sql_users = "INSERT INTO users (dt_reg, email, password, user_name, contact_info) 
				VALUES (NOW(), ?, ?, ?, ?);";

        //Создает подготовленное выражение на основе готового SQL запроса и переданных данных
        $insert_users = db_insert_data($mysqli_connect, $sql_users, [
            $_POST['email'],
            $password,
            $_POST['name'],
            $_POST['message']
        ]);

        if ($insert_users) {
            header("Location: login.php");
            exit();
        }
    }
}

// Подключение шаблонов
$sign_up_content = include_template('sign-up.php', [
    'errors_sign_up' => $errors_sign_up,
]);

$layout_content = include_template('layout.php', [
    'content' => $sign_up_content,
    'categories' => $categories,
    'title' => 'Регистрация'
   // 'user_name' => $user_name,
    //'is_auth' => $is_auth      //Рандомная функция
]);
print($layout_content);
