<?php
require_once 'config/init.php';

$page_title = 'readme: регистрация';
$errors = [];
$form = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form = filter_input_array(INPUT_POST, ['login' => FILTER_DEFAULT, 'password' => FILTER_DEFAULT], true);
    $form = trim_array($form);
    $required = [
        'login' => 'Логин',
        'password' => 'Пароль',
    ];

    $errors = get_required_errors($user, $required);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['login'] = 'Неправильный формат почты';
    }

    $user = get_user_by_mail($con, $form['login']);

    if (empty($errors) and $user) {
        if (password_verify($form['password'], $user['password'])) {
            $_SESSION['user'] = $user;
        } else {
            $errors['password'] = "Неверный пароль";
        }
    } else {
        $errors['login'] = 'Такой пользователь не найден';
    }

    $errors = array_filter($errors);

    if(empty($errors)) {
        header('Location: index.php');
        exit();
    }
}

$main_leyout = include_template('main.php', [
    'page_title' => $page_title,
    'form' => $form,
    'errors' => $errors
]);

print($main_layout);
