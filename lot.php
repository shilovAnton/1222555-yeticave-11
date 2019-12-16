<?php
date_default_timezone_set('Asia/Novosibirsk');//Часовой пояс
require_once('helpers.php'); //Подключаем файл
require_once('user.php');
require_once('categories.php');
require_once('mysqli_connect.php');

// Обращаемся к $_GET и проверяем на существование id
$lot_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (empty($lot_id)) {  //Проверяет переменную, возвращает true если переменной нет, или равна NULL
    header("HTTP/1.0 404 Not Found");
    die;
}

// Запрос лота по id
$query_lot = "SELECT lots.id, lot_name, initial_price, img, MAX(bid_price) as current_price, category_name,dt_end, description, bid_step
FROM lots
         LEFT JOIN bids ON lots.id = bids.lot_id
         LEFT JOIN categories c on lots.category_id = c.id
WHERE lots.id = {$lot_id}
GROUP BY lots.id;";
$result_lot = mysqli_query($mysqli_connect, $query_lot);// функция для выполнения любых SQL запросов
if ($result_lot) {
    $lot = mysqli_fetch_assoc($result_lot);
} else {
    show_error($mysqli_connect);
}
if (!isset($lot)){
    header("HTTP/1.0 404 Not Found");
    die;
}

// Подключение шаблонов
$lot_content = include_template('lot.php', [
    'lot' => $lot,
]);

$layout_content = include_template('layout.php',[
    'content' => $lot_content,
    'categories' => $categories,
    'title' => $lot['lot_name'],
    'user_name' => $user_name,
    'is_auth' => $is_auth   //Рандомная функция
]);
print($layout_content);


