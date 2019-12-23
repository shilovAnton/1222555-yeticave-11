<?php
require_once('attach_file.php');

//Закрываем доступ для не залогиненых
if (!$user) {
    http_response_code(403);
    exit();
}

//Получаем список ставок
$sql = "SELECT lots.id, lot_name, img, category_name, DATE_FORMAT(bids.dt_add, '%d.%m.%y в %H : %i') as dt_format, dt_end, bid_price, email, contact_info, user_id_winner
FROM bids LEFT JOIN lots ON bids.lot_id = lots.id
LEFT JOIN categories ON lots.category_id = categories.id
LEFT JOIN users ON lots.user_id_author = users.id
WHERE bids.user_id = {$_SESSION['user']['id']}  
ORDER BY dt_format DESC";

$result = mysqli_query($mysqli_connect, $sql);
if ($result) {
    $my_bids = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    show_error($mysqli_connect);
}
// Подключение шаблонов
$page_content = include_template('my-bets.php',[
    'my_bids' => $my_bids
]);

$layout_content = include_template('layout.php',[
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Мои ставки',
    'user' => $user
]);
print($layout_content);
