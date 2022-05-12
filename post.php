<?php

require_once 'config/init.php';

$page_title = 'readme: публикация';

$post_id = filter_input(INPUT_GET, 'post_id', FILTER_SANITIZE_NUMBER_INT);

$post_ids = get_post_ids($con);

// Валидация типа контента
if (check_id($post_ids, $post_id)) {
    show_error("Пост будет написан в ближайшее время.");
}

$post = get_post($con, $post_id);
$comments = get_comments($con, $post_id);
$user_id = (int) $post['user_id'];
$is_show_comments = filter_input(INPUT_GET, 'is_show_comments');
$new_comment = [];
$errors = [];
$required = [
    'comment_text' => 'Ваш комментарий',
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $author_id = 1;
    $new_comment = filter_input_array(INPUT_POST, ['comment_text' => FILTER_DEFAULT], true);
    $sql = "INSERT INTO comment (user_id, post_id, text) VALUES ($author_id, $post_id, ?)";

    $errors = get_required_errors($new_comment, $required);
    $errors = array_filter($errors);

    if(empty($errors)) {
        $stmt = db_get_prepare_stmt($con, $sql, $new_comment);
        $result = mysqli_stmt_execute($stmt);

        header('Location: post.php?post_id=' . $post_id);

        if (!$result) {
            show_error(mysqli_error($con));
        }
    }
}

$page_content = include_template('post-details.php', [
    'post' => $post,
    'comments' => $comments,
    'comments_start' => array_slice($comments, 0, 2),
    'comments_more' => array_slice($comments, 2),
    'user_count_posts' => get_count_posts($con, $user_id),
    'user_count_subscribes' => get_count_subscribers($con, $user_id),
    'tags' => get_tags($con, $post_id),
    'is_show_comments' => $is_show_comments,
    'new_comment' => $new_comment,
    'errors' => $errors
]);

$page_layout = include_template('page-layout.php', [
    'page_title' => $page_title,
    'user' => $user,
    'page_content' => $page_content
]);

print($page_layout);
