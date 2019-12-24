<?php

require_once('core.php');

// Обращаемся к $_GET и проверяем на существование id
$category_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (empty($category_id)) {  //Проверяет переменную, возвращает true если переменной нет, или равна NULL
    header("HTTP/1.0 404 Not Found");
    die;
}

// Пагинация
$cur_page = $_GET['page'] ?? 1;
$page_items = 9;

$sql_count = "SELECT COUNT(*) as count_lot
FROM lots
WHERE category_id = (?) AND dt_end > NOW()";

$items_count_result = db_fetch_data($mysqli_connect, $sql_count, [$category_id]);
$items_count = $items_count_result[0]['count_lot'];

$pages_count = ceil($items_count / $page_items);
$offset = ($cur_page - 1) * $page_items;

$pages = [];
if ($pages_count > 0) {
    $pages = range(1, $pages_count);
}


// Запрос для страницы с категориями
$sql = "SELECT lots.id, lot_name, initial_price, img, MAX(bid_price) as current_price, category_name,dt_end
FROM lots
         LEFT JOIN bids ON lots.id = bids.lot_id
         LEFT JOIN categories c on lots.category_id = c.id
WHERE category_id = '{$category_id}' AND dt_end > NOW()
GROUP BY lots.id
ORDER BY lots.dt_add DESC LIMIT $page_items OFFSET $offset";
$result_lots = mysqli_query($mysqli_connect, $sql);
if ($result_lots) {
    $lots = mysqli_fetch_all($result_lots, MYSQLI_ASSOC);
} else {
    show_error($mysqli_connect);
}

// Подключение шаблонов
$page_content = include_template(
    'all-lots.php',
    [
        'lots' => $lots,
        'pages' => $pages,
        'category_id' => htmlspecialchars($category_id),
        'cur_page' => $cur_page,
    ]
);

$layout_content = include_template(
    'layout.php',
    [
        'content' => $page_content,
        'categories' => $categories,
        'title' => 'YetiCave - Все лоты',
        'user' => $user
    ]
);
print($layout_content);
