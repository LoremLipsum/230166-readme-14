<?php

require_once 'config/init.php';

$page_title = 'readme: добавление публикации';

$type_id = (int) filter_input(INPUT_GET, 'type_id', FILTER_SANITIZE_NUMBER_INT);

$errors = [];
$post = [];
$tag = NULL;

$types = get_all_types($con);

// Проверяем есть ли текущий id в категориях
if ($type_id && check_id($types, $type_id)) {
    show_error("Такая категория пока не создана.");
}

// Обязательные поля
$required = [
    'title' => 'Заголовок',
    'text' => 'Текст поста',
    'tag' => 'Тэги',
    'link_url' => 'Ссылка',
    'quote' => 'Текст цитаты',
    'caption' => 'Автор',
    'video_url' => 'Ссылка youtube'
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $type_id = filter_input(INPUT_POST, 'type_id', FILTER_SANITIZE_NUMBER_INT);
    $file_name = $_FILES['img_file']['name'] ?? NULL;

    switch ($type_id) {
        // Текст
        case 1:
            $post = filter_input_array(INPUT_POST, ['type_id' => FILTER_DEFAULT, 'title' => FILTER_DEFAULT, 'text' => FILTER_DEFAULT], true);
            $sql = "INSERT INTO post (user_id, type_id, title, text) VALUES (1, ?, ?, ?)";
            break;
        // Цитата
        case 2:
            $post = filter_input_array(INPUT_POST, ['type_id' => FILTER_DEFAULT, 'title' => FILTER_DEFAULT, 'quote' => FILTER_DEFAULT, 'caption' => FILTER_DEFAULT], true);
            $sql = "INSERT INTO post (user_id, type_id, title, quote, caption) VALUES (1, ?, ?, ?, ?)";
            break;
        // Фото
        case 3:
            $post = filter_input_array(INPUT_POST, ['type_id' => FILTER_DEFAULT, 'title' => FILTER_DEFAULT, 'photo_url' => FILTER_DEFAULT], true);
            $sql = "INSERT INTO post (user_id, type_id, title, photo_url) VALUES (1, ?, ?, ?)";
            $errors['photo_url'] = !$file_name && !$post['photo_url'] ? 'Вы не загрузили файл' : NULL;
            break;
        // Видео
        case 4:
            $post = filter_input_array(INPUT_POST, ['type_id' => FILTER_DEFAULT, 'title' => FILTER_DEFAULT, 'video_url' => FILTER_DEFAULT], true);
            $sql = "INSERT INTO post (user_id, type_id, title, video_url) VALUES (1, ?, ?, ?)";
            $video_url = $post['video_url'];
            $errors['video_url'] = validate_url($video_url);
            if (!$errors['video_url']) {
                $errors['video_url'] = validate_youtube_url($video_url);
            }
            break;
        // Ссылка
        case 5:
            $post = filter_input_array(INPUT_POST, ['type_id' => FILTER_DEFAULT, 'title' => FILTER_DEFAULT, 'link_url' => FILTER_DEFAULT], true);
            $sql = "INSERT INTO post (user_id, type_id, title, link_url) VALUES (1, ?, ?, ?)";
            $link_url = $post['link_url'];
            $errors['link_url'] = validate_url($link_url);
            break;
    }

    if ($file_name) {
        $tmp_name = $_FILES['img_file']['tmp_name'];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = finfo_file($finfo, $tmp_name);

        if ($file_type === 'image/jpeg') {
            $ext = '.jpg';
        } elseif ($file_type === 'image/png') {
            $ext = '.png';
        } elseif ($file_type === 'image/gif') {
            $ext = '.gif';
        }

        if ($ext) {
            $filename = uniqid() . $ext;
            move_uploaded_file($_FILES['img_file']['tmp_name'], 'uploads/'. $filename);
            $post['photo_url'] = "uploads/". $filename;
        } else {
            $errors['photo_url'] = 'Допустимые форматы файлов: jpg, jpeg, png, gif.';
        }
    }

    $tag = trim(filter_input(INPUT_POST, 'tag'));
    $all_input = $post;
    $all_input['tag'] = $tag;

    $required_errors = get_required_errors($all_input, $required);
    $errors = array_merge($errors, $required_errors);
    $errors = array_filter($errors);

    if(empty($errors)) {
        $stmt = db_get_prepare_stmt($con, $sql, $post);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            $post_id = mysqli_insert_id($con);

            // Привязка тегов к публикации
            $tags = explode(' ', $tag);

            foreach ($tags as $tag) {
                $sql = "SELECT * FROM tag WHERE text = '{$tag}'";
                $result = mysqli_query($con, $sql);
                $exist_tag = mysqli_fetch_assoc($result);

                if ($exist_tag) {
                    $tag_id = $exist_tag['id'];
                } else {
                    $sql = "INSERT INTO tag SET text = '{$tag}'";
                    $result = mysqli_query($con, $sql);
                    $tag_id = mysqli_insert_id($con);
                }

                $sql = "INSERT INTO post_tag (post_id, tag_id) VALUES ({$post_id}, {$tag_id})";
                $result = mysqli_query($con, $sql);
            }

            header('Location: post.php?post_id=' . $post_id);
        }
        else {
            show_error(mysqli_error($con));
        }
    }
}

$page_content = include_template('adding-post.php', [
    'types' => $types,
    'errors' => $errors,
    'type_id' => $type_id,
    'post' => $post,
    'tag' => $tag
]);

$page_layout = include_template('page-layout.php', [
    'page_title' => $page_title,
    'user' => $user,
    'page_content' => $page_content
]);

print($page_layout);
