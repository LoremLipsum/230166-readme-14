<?php
define('POST_LIMIT', 300);

$is_auth = rand(0, 1);
$user_name = 'Margarita';
$popular_posts = [
    0 => [
        'title' => 'Цитата',
        'type' => 'post-quote',
        'content' => 'Мы в жизни любим только раз, а после ищем лишь похожих',
        'user_name' => 'Лариса',
        'avatar' => 'userpic-larisa-small.jpg'
    ],
    1 => [
        'title' => 'Игра престолов',
        'type' => 'post-text',
        'content' => 'Не могу дождаться начала финального сезона своего любимого сериала!',
        'user_name' => 'Владик',
        'avatar' => 'userpic.jpg'
    ],
    2 => [
        'title' => 'Наконец, обработал фотки!',
        'type' => 'post-photo',
        'content' => 'rock-medium.jpg',
        'user_name' => 'Виктор',
        'avatar' => 'userpic-mark.jpg'
    ],
    3 => [
        'title' => 'Моя мечта',
        'type' => 'post-photo',
        'content' => 'coast-medium.jpg',
        'user_name' => 'Лариса',
        'avatar' => 'userpic-larisa-small.jpg'
    ],
    4 => [
        'title' => 'Лучшие курсы',
        'type' => 'post-link',
        'content' => 'www.htmlacademy.ru',
        'user_name' => 'Владик',
        'avatar' => 'userpic.jpg'
    ],
    5 => [
        'title' => 'Байкал',
        'type' => 'post-text',
        'content' => 'Байкал – самое глубоководное озеро в мире, оно расположено в Восточной Сибири. Также Байкал - самое большое пресноводное озеро в Евразии. В нем содержится 20% всей пресной воды на Земле. Уникальная особенность озера - его необычайно чистая и прозрачная вода, богатство животного и растительного мира. Байкал – одно из главных природных достояний России, источник множества легенд и загадок. Он считается «местом силы» и особой энергетики.',
        'user_name' => 'Владик',
        'avatar' => 'userpic.jpg'
    ]
];
