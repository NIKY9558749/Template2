<?php
session_start();

$fake_email = 'admin@google.com';
$fake_password = '123';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['login-email']) ? $_POST['login-email'] : '';
    $password = isset($_POST['login-password']) ? $_POST['login-password'] : '';

    if ($email === $fake_email && $password === $fake_password) {
        $_SESSION['logged_in'] = true;
        $_SESSION['user_email'] = $email;

        unset($_SESSION['login_error']);
        header('Location: profilo.php');
        exit;
    } else {
        $_SESSION['login_error'] = true;
        header('Location: index.php?error=1');
        exit;
    }
} else {
    header('Location: index.php');
    exit;
}
