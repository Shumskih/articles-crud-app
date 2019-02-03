<?php

include $_SERVER['DOCUMENT_ROOT'] . '/helpers/connectToDB.php';
include $_SERVER['DOCUMENT_ROOT'] . '/helpers/access.php';

$headTitle = 'Вход';

session_start();

if (!isset($_POST['submit']))
    include $_SERVER['DOCUMENT_ROOT'] . '/views/login/login.html.php';

if (isset($_POST['submit'])) {

    if (!isset($_POST['email']) or $_POST['email'] == '' or
        !isset($_POST['password']) or $_POST['password'] == '') {

        $GLOBALS['loginError'] = 'Необходимо заполнить все поля';

        include $_SERVER['DOCUMENT_ROOT'] . '/views/login/login.html.php';
    }

    $password = md5($_POST['password'] . 'php_and_mysql');

    if (databaseContainsUser($pdo, $_POST['email'], $password)) {
        session_start();
        $_SESSION['loggedIn'] = true;
        $_SESSION['email'] = $_POST['email'];
        $_SESSION['password'] = $_POST['password'];

        include $_SERVER['DOCUMENT_ROOT'] . '/views/login/success/success.html.php';
    } else {
        session_start();
        unset($_SESSION['loggedIn']);
        unset($_SESSION['email']);
        unset($_SESSION['password']);

        $GLOBALS['loginError'] = 'Указан неверный адрес электронной почты или пароль';

        include $_SERVER['DOCUMENT_ROOT'] . '/views/login/login.html.php';
    }
}
