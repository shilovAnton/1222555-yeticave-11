/* Список категорий */
INSERT INTO categories
    (category_name, symbol_code)
VALUES ('Доски и лыжи', 'boards'),
       ('Крепления', 'attachment'),
       ('Ботинки', 'boots'),
       ('Одежда', 'clothing'),
       ('Инструменты', 'tools'),
       ('Разное', 'other');

/* Добавляем пользователй */
INSERT INTO users
    (dt_reg, email, user_name, password, contact_info)
VALUES ('2019-11-09', 'shilov.a.a.1986@gmail.com', 'Антон', 123456789, 'т. 89502631889'),
       ('2019-11-01', 'hacker@gmail.com', 'Иванов Иван', 987654321, 'т. 9504567856');

/* Добавляем объявления */
INSERT INTO lots
(dt_add, lot_name, description, img, initial_price, dt_end, bid_step, user_id_author, category_id)
VALUES ('2019-11-09', '2014 Rossignol District Snowboard', 'В идеальном состоянии', 'img/lot-1.jpg', 10999,
        '2019-11-11', 100, 1, 1),
       ('2019-11-10', 'DC Ply Mens 2016/2017 Snowboard', 'бла бла бла', 'img/lot-2.jpg', 159999, '2019-11-14', 500,
        2, 1),
       ('2019-11-11', 'Крепления Union Contact Pro 2015 года размер L/XL', 'Все работает отлично', 'img/lot-3.jpg',
        8000, '2019-11-12', 1000, 1, 2),
       ('2019-11-08', 'Ботинки для сноуборда DC Mutiny Charocal', '47 размер', 'img/lot-4.jpg', 10999, '2019-11-13',
        200, 2, 3),
       ('2019-11-07', 'Куртка для сноуборда DC Mutiny Charocal', 'Куртка - супер!', 'img/lot-5.jpg', 7500, '2019-11-15',
        300, 1, 4),
       ('2019-11-06', 'Маска Oakley Canopy', 'Хорошая маска, в идеале', 'img/lot-6.jpg', 5400, '2019-11-24', 400, 2,
        6);

/* Добавляем ставки */
INSERT INTO bids
    (bid_price, user_id, lot_id)
VALUES (12000, 1, 1),
       (200000, 2, 2),
       (300000, 1, 2);


/* Удаление записей
DELETE
FROM users
WHERE email = 'shilov.a.a.1986@gmail.com';  */

/* Получить все категории */
SELECT category_name
FROM categories;

/* получить самые новые, открытые лоты. Каждый лот должен включать название, стартовую цену, ссылку на изображение,
текущую цену, название категории */

SELECT lots.id, lot_name, initial_price, img, MAX(bid_price) as current_price, category_name
FROM lots
         LEFT JOIN bids ON lots.id = bids.lot_id
         LEFT JOIN categories c on lots.category_id = c.id
WHERE dt_end > NOW()
GROUP BY lots.id
ORDER BY lots.dt_add DESC LIMIT 6;


/* показать лот по его id. Получите также название категории, к которой принадлежит лот */

SELECT lot_name, category_name
FROM lots
        JOIN categories ON lots.category_id = categories.id
WHERE lots.id=3;

/* обновить название лота по его идентификатору */

UPDATE lots
SET lot_name='Поменял'
WHERE id = 2;

/* получить список ставок для лота по его идентификатору с сортировкой по дате */

SELECT bid_price
FROM bids
WHERE lot_id=4
ORDER BY dt_add;














