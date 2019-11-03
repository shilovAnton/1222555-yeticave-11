<?php
    require_once('helpers.php');

    $user_name = 'Антон'; // укажите здесь ваше имя
    
    $is_auth = rand(0, 1);

    $categories = ["Доски и лыжи","Крепления","Ботинки","Одежда","Инструменты","Разное"];//Одномерный массив 
    
    $goods = [   //Двумерный массив
        [
            'name' => '2014 Rossignol District Snowboard',
            'category' => 'Доски и лыжи',
            'price' => 10999,
            'img' => 'img/lot-1.jpg',
            'дата истечения' => '2019-11-04'
        ],
        [
            'name' => 'DC Ply Mens 2016/2017 Snowboard',
            'category' => 'Доски и лыжи',
            'price' => 159999,
            'img' => 'img/lot-2.jpg',
            'дата истечения' => '2020-01-01'
        ], 
        [
            'name' => 'Крепления Union Contact Pro 2015 года размер L/XL',
            'category' => 'Крепления',
            'price' => 8000,
            'img' => 'img/lot-3.jpg',
            'дата истечения' => '2019-12-31'
        ],
        [
            'name' => 'Ботинки для сноуборда DC Mutiny Charocal',
            'category' => 'Ботинки',
            'price' => 10999,
            'img' => 'img/lot-4.jpg',
            'дата истечения' => '2019-12-24'
        ],
        [
            'name' => 'Куртка для сноуборда DC Mutiny Charocal',
            'category' => 'Одежда',
            'price' => 7500,
            'img' => 'img/lot-5.jpg',
            'дата истечения' => '2019-11-29'
        ],
        [
            'name' => 'Маска Oakley Canopy',
            'category' => 'Разное',
            'price' => 5400,
            'img' => 'img/lot-6.jpg',
            'дата истечения' => '2019-11-26'
        ]
        ];
    ?>

<?php // Подключение шаблонов
    $page_content = include_template('main.php', ['goods' => $goods,
         'categories' =>  $categories,
         
        // 'dt' => $time_count
    ]);
    $layout_content = include_template('layout.php', ['content' => $page_content,
        'categories' =>  $categories,
        'title' => 'YetiCave - Главная страница',
        'user_name' => $user_name,
        'is_auth' => $is_auth,//Рандомная функция

    ]);
    print($layout_content);

    // Функция подсчета отавшегося времени
    
    //setlocale(LC_ALL,'en_DK');
    
    //$int_end = "2019-11-26";
    //$d_end = date_create($int_end);
    // $dt_now = date_create("now");
    //$dt_diff = date_diff($d_end,$dt_now);
    //$time_count = date_interval_format($diff, "%d")

    function time_to_finish($data_finish) {
        date_default_timezone_set('(Asia/Novosibirsk');

        $timestamp_finish = strtotime($data_finish); //Метка времени из текстового представления
        $timestamp_start = time();
        $interval = $timestamp_finish - $timestamp_start - 4 * 3600;
        $hours = floor($interval/3600);
        $minuts = floor(($interval % 3600)/60);
        $hours_for_output = str_pad($hours, 2, "0", STR_PAD_LEFT);
        $minuts_for_output = str_pad($minuts, 2, "0", STR_PAD_LEFT);

    return $output = "$hours_for_output:$minuts_for_output";
    }

?>