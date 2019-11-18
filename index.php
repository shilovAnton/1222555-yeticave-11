<?php
require_once('helpers.php'); //Подключаем файл
date_default_timezone_set('Asia/Novosibirsk');//Часовой пояс
$user_name = 'Антон'; // укажите здесь ваше имя
$is_auth = rand(0, 1);//Рандомная


// Подключение БД
$con = mysqli_connect("localhost", "root", "", "yeticave");//Подключение БД, ресурс соединения
if ($con == false) {
    print("Ошибка подключения: " . mysqli_connect_error());
} else {
    mysqli_set_charset($con, "utf8");  // Установить кодировку

    $sql = "SELECT * FROM categories";
    $result = mysqli_query($con, $sql);  // функция для выполнения любых SQL запросов
    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $query_lots = "SELECT lots.id, lot_name, initial_price, img, MAX(bid_price) as current_price, category_name,dt_end
FROM lots
         LEFT JOIN bids ON lots.id = bids.lot_id
         LEFT JOIN categories c on lots.category_id = c.id
WHERE dt_end > NOW()
GROUP BY lots.id
ORDER BY lots.dt_add DESC LIMIT 6";
    $result_lots = mysqli_query($con, $query_lots);
    $goods = mysqli_fetch_all($result_lots, MYSQLI_ASSOC);
    if (!$result or !$result_lots) {
        $error = mysqli_error($con);
        print("Ошибка MySQL: " . $error);
    }
}
?>

<?php // Подключение шаблонов
$page_content = include_template('main.php', [
    'goods' => $goods,
    'categories' => $categories,
]);

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'YetiCave - Главная страница',
    'user_name' => $user_name,
    'is_auth' => $is_auth//Рандомная функция

]);
print($layout_content);
?>
