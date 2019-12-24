<?php

require_once('core.php');

if (!$user) {
    http_response_code(403);
    exit();
}
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Удаляет теги
    $strip_tags_fields = ['lot_name', 'description'];
    foreach ($strip_tags_fields as $field) {
        if (isset($_POST[$field])) {
            $_POST[$field] = strip_tags($_POST[$field]);
        }
    }
    //Проверка на полей на пустоту
    $required_fields = ['lot_name', 'category_id', 'description', 'initial_price', 'bid_step', 'dt_end'];
    foreach ($required_fields as $field) {  //Обязательные поля
        if (empty($_POST[$field])) {
            $errors[$field] = 'Поле не заполнено';
        }
    }
    // Проверка категории
    $unavailableCategory = true; //Категория недопустима
    foreach ($categories as $category) {
        if ($_POST['category_id'] == $category['id']) {
            $unavailableCategory = false;
        }
    }
    if ($unavailableCategory) {
        $errors['category_id'] = 'Выберите категорию';
    }

    $integer_fields = ['initial_price', 'bid_step'];  // Проверка цены
    foreach ($integer_fields as $field) {
        if (!ctype_digit($_POST[$field]) OR ($_POST[$field] <= 0)) {
            $errors[$field] = 'Содержимое поля должно быть целым числом больше нуля';
        }
    }
    $dt_end = $_POST['dt_end']; //Проверка даты
    if (!is_date_valid($dt_end)) {
        $errors['dt_end'] = 'дата должна быть в формате «ГГГГ-ММ-ДД»';
    }
    if
    (((strtotime($dt_end)) - time()) < 86400) {
        $errors['dt_end'] = 'Дата завершения должна быть больше текущей, хотя бы на один день.';
    }

    if (!empty($_FILES['img'])) { // Проверка и загрузка изображения
        $file_name = $_FILES['img']['tmp_name'];
        $file_type = mime_content_type($file_name);
        $available_image_mime_types = ['image/png', 'image/jpeg'];
        if (!in_array($file_type, $available_image_mime_types)) {
            $errors['img'] = "Загрузите картинку в формате png или jpeg";
        }
        $file_size = $_FILES['img']['size'];
        if ($file_size > 1000000) {
            $errors['img'] = "Максимальный размер файла: 1 Мб";
        }
    } else {
        $errors['img'] = "Загрузите картинку";
    }

    if (empty($errors)) { //Если ошибок нет, загружаем картинку
        $file_path = __DIR__ . '/uploads/'; // это полный путь к дериктории где будет храниться файл.
        //Перемещает загруженный файл в новое место
        move_uploaded_file($_FILES['img']['tmp_name'], $file_path . $_FILES['img']['name']);

        //SQL запрос с плейсхолдерами вместо значений
        $sql = "INSERT INTO lots (dt_add, user_id_author, lot_name, category_id, description, img, initial_price, bid_step, dt_end)
				VALUES (NOW(), ?, ?, ?, ?, ?, ?, ?, ?)";

        //Создает подготовленное выражение на основе готового SQL запроса и переданных данных
        $insert_lot = db_insert_data(
            $mysqli_connect,
            $sql,
            [
                $user['id'],
                $_POST['lot_name'],
                $_POST['category_id'],
                $_POST['description'],
                '/uploads/' . $_FILES['img']['name'],
                $_POST['initial_price'],
                $_POST['bid_step'],
                $_POST['dt_end']
            ]
        );

        if ($insert_lot) {
            header("Location: lot.php?id=$insert_lot");
            exit();
        }
    }
}

// Подключение шаблонов
$add_content = include_template(
    'add.php',
    [
        'categories' => $categories,
        'errors' => $errors
    ]
);

$layout_content = include_template(
    'layout.php',
    [
        'content' => $add_content,
        'categories' => $categories,
        'title' => 'Добавление лота',
        'user' => $user
    ]
);
print($layout_content);


