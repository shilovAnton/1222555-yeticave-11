<?php
require_once('helpers.php'); //Подключаем файл
require_once('mysqli_connect.php');
require_once('categories.php');
require_once('user.php');
date_default_timezone_set('Asia/Novosibirsk');


if (!empty($_POST)) {  // Проверяем сущесвованин массива
    $insert_lot = "INSERT INTO lots
SET user_id_author = 1, lot_name = '{$_POST['lot_name']}', category_id = '{$_POST['category_id']}', description = '{$_POST['description']}',
    img = '{$_POST['img']}', initial_price = '{$_POST['initial_price']}',bid_step = '{$_POST['bid_step']}', dt_end = '{$_POST['dt_end']}'";

    $result_add_lot = mysqli_query($mysqli_connect, $insert_lot);
    if (!$result_add_lot) {
        show_error($mysqli_connect);
    }

}

// Подключение шаблонов
$add_content = include_template('add.php',[
    'categories' => $categories,
]);

$layout_content = include_template('layout.php',[
    'content' => $add_content,
    'categories' => $categories,
    'title' => 'Добавление лота',
    'user_name' => $user_name,
    'is_auth' => $is_auth//Рандомная функция

]);
print($layout_content);
