<?php
date_default_timezone_set('Asia/Novosibirsk');//Часовой пояс
require_once('helpers.php'); //Подключаем файл
require_once('mysqli_connect.php');
require_once('categories.php');
require_once('user.php');


// Запрос для главной страницы
$query_lots = "SELECT lots.id, lot_name, initial_price, img, MAX(bid_price) as current_price, category_name,dt_end
FROM lots
         LEFT JOIN bids ON lots.id = bids.lot_id
         LEFT JOIN categories c on lots.category_id = c.id
WHERE dt_end > NOW()
GROUP BY lots.id
ORDER BY lots.dt_add DESC LIMIT 6";
$result_lots = mysqli_query($mysqli_connect, $query_lots);
if ($result_lots) {
    $lots = mysqli_fetch_all($result_lots, MYSQLI_ASSOC);
} else {
    show_error($mysqli_connect);
}

// Подключение шаблонов
$page_content = include_template('main.php',[
    'lots' => $lots,
    'categories' => $categories,
]);

$layout_content = include_template('layout.php',[
    'main' => true,
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'YetiCave - Главная страница',
    //'user_name' => $user_name,
   // 'is_auth' => $is_auth//Рандомная функция

]);
print($layout_content);


