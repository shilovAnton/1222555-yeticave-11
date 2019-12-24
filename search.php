<?php

require_once('core.php');

$search = $_GET['search'] ?? '';
$search_valid = trim($search);

if ($search_valid) {
    // Пагинация
    $cur_page = $_GET['page'] ?? 1;
    $page_items = 9;

    $sql_count = "SELECT COUNT(*) as cnt
FROM lots
WHERE  MATCH(lot_name, description) AGAINST(?) AND dt_end > NOW()";

    $items_count_result = db_fetch_data($mysqli_connect, $sql_count, [$search_valid]);
    $items_count = $items_count_result[0]['cnt'];

    $pages_count = ceil($items_count / $page_items);
    $offset = ($cur_page - 1) * $page_items;

    $pages = range(1, $pages_count);

    // Основной запрос
    $sql = "SELECT lots.id, lot_name, initial_price, img, MAX(bid_price) as current_price, category_name,dt_end, description, bid_step
FROM lots
         LEFT JOIN bids ON lots.id = bids.lot_id
         LEFT JOIN categories c on lots.category_id = c.id
WHERE  MATCH(lot_name, description) AGAINST(?) AND dt_end > NOW()
GROUP BY lots.id
ORDER BY lots.dt_add DESC LIMIT $page_items OFFSET $offset";

    $lots = db_fetch_data($mysqli_connect, $sql, [$search_valid]);
} else {
    $lots = [];
}


// Подключение шаблонов
$search_content = include_template(
    'search.php',
    [
        'lots' => $lots,
        'pages' => $pages,
        'search_valid' => htmlspecialchars($search_valid),
        'cur_page' => $cur_page,

    ]
);

$layout_content = include_template(
    'layout.php',
    [
        'content' => $search_content,
        'categories' => $categories,
        'title' => 'YetiCave - Результаты поиска',
        'user' => $user
    ]
);
print($layout_content);
