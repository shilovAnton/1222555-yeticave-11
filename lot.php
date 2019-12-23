<?php
require_once('attach_file.php');

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

// запрос для истори ставок
$sql_history = "SELECT user_name, DATE_FORMAT(bids.dt_add, '%d.%m.%y в %H : %i') as dt_format, bid_price FROM bids
    LEFT JOIN users ON bids.user_id = users.id
WHERE bids.lot_id = (?)
ORDER BY bid_price DESC LIMIT 10";
   $result_history = db_fetch_data($mysqli_connect, $sql_history, [$lot_id]);
   $count = count($result_history);


//Проверка формы
$errors = [];

$price = $lot['current_price'] ?? $lot['initial_price'];
$min_bid = $price + $lot['bid_step'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$user) {
        http_response_code(403);
        exit();
    } else {
        $cost = $_POST['cost'] ?? '';

        if (empty($cost)) {
            $errors['cost'] = "Введите вашу ставку";
        }

        if ((!ctype_digit($cost)) OR ($cost < $min_bid)) {
            $errors['cost'] = "Цена должна быть целым числом боьше текущщей ставки, с учетом шага ставки";
        }
    }


    if (!count($errors)) {
        $sql = "INSERT INTO bids (dt_add, bid_price, user_id, lot_id) 
				VALUES (NOW(), ?, ?, ?)";
        db_insert_data($mysqli_connect, $sql, [$cost, $_SESSION['user']['id'], $lot['id']]);

        //Делаем переадресацию на эту же страницу
        header("Location: lot.php?id=" . $lot['id']);
        exit();
    }
}

// Подключение шаблонов
$lot_content = include_template('lot.php', [
    'errors' => $errors,
    'lot' => $lot,
    'user' => $user,
    'min_bid' => $min_bid,
    'result_history' => $result_history,
    'count' => $count,
]);

$layout_content = include_template('layout.php',[
    'content' => $lot_content,
    'categories' => $categories,
    'title' => $lot['lot_name'],
    'user' => $user
]);
print($layout_content);


