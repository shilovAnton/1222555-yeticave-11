<?php

// Подключение БД
$mysqli_connect = mysqli_connect("localhost", "root", "", "yeticave");//Подключение БД, ресурс соединения
if ($mysqli_connect == false) {
    print("Ошибка подключения: " . mysqli_connect_error());
    die;
}

mysqli_set_charset($mysqli_connect, "utf8");  // Установить кодировку

/**
 * Выводит ошибку если соединение с БД не установлено.
 * @param $mysqli_connect
 *
 */
function show_error($mysqli_connect)
{
    $error = mysqli_error($mysqli_connect);
    print("Ошибка MySQL: " . $error);
    die;
}

date_default_timezone_set('Asia/Novosibirsk');//Часовой пояс
