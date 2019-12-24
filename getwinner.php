<?php

require_once "vendor/autoload.php";
require_once('core.php');

// запрос "Найти все лоты без победителей, дата истечения которых меньше или равна текущей дате."
$sql_for_win = "SELECT * FROM lots
WHERE
dt_end <= NOW()
AND user_id_winner IS NULL";

$result_sql = mysqli_query($mysqli_connect, $sql_for_win);
if ($result_sql) {
    $lots = mysqli_fetch_all($result_sql, MYSQLI_ASSOC);
} else {
    show_error($mysqli_connect);
}

// Create the Transport
$transport = (new Swift_SmtpTransport('phpdemo.ru', 25))
    ->setUsername('keks@phpdemo.ru')
    ->setPassword('htmlacademy');

// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);

foreach ($lots as $lot) {
    $sql_for_bid = "SELECT bids.*, users.email, users.user_name FROM bids
INNER JOIN users ON users.id = bids.user_id
WHERE
lot_id = {$lot['id']}
ORDER BY dt_add DESC
LIMIT 1";

    $resul = mysqli_query($mysqli_connect, $sql_for_bid);
    if ($resul) {
        $bid = mysqli_fetch_assoc($resul);
    } else {
        show_error($mysqli_connect);
    }
    //Записать в лот победителем автора последней ставки.
    $sql_for_bid = "UPDATE lots SET user_id_winner = {$bid['user_id']}
WHERE id = {$bid['lot_id']}";
    mysqli_query($mysqli_connect, $sql_for_bid);

    $text = include_template(
        'email.php',
        [
            'lot' => $lot,
            'user_name' => $bid['user_name']
        ]
    );

// Create a message
    $message = (new Swift_Message('Ваша ставка победила'))
        ->setFrom(['keks@phpdemo.ru' => 'keks@phpdemo.ru'])
        ->setTo($bid['email'])
        ->setBody($text, 'text/html');

// Send the message
    $result = $mailer->send($message);
}







