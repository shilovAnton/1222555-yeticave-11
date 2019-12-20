<?php
require_once('attach_file.php');

$search = $_GET['search'] ?? '';

if ($search) {
    $sql = "SELECT lots.id, lot_name, initial_price, img, MAX(bid_price) as current_price, category_name,dt_end, description, bid_step,
       COUNT(bid_price) as bid
FROM lots
         LEFT JOIN bids ON lots.id = bids.lot_id
         LEFT JOIN categories c on lots.category_id = c.id
WHERE  MATCH(lot_name, description) AGAINST(?) 

GROUP BY lots.id";

    $lots = db_fetch_data($mysqli_connect, $sql, [$search]);
}


// Подключение шаблонов
$search_content = include_template('search.php', [
    'lots' => $lots
]);

$layout_content = include_template('layout.php', [
    'content' => $search_content,
    'categories' => $categories,
    'title' => 'YetiCave - Результаты поиска',
    'user' => $user
]);
print($layout_content);
