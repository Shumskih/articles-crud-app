<?php

include $_SERVER['DOCUMENT_ROOT'] . '/helpers/connectToDB.php';
include $_SERVER['DOCUMENT_ROOT'] . '/helpers/access.php';

session_start();

if (isset($_SESSION['loggedIn'])) {
    unset($_SESSION['loggedIn']);
    unset($_SESSION['email']);
    unset($_SESSION['password']);
    unset($_SESSION['editor']);
    unset($_SESSION['account_administrator']);
    unset($_SESSION['site_administrator']);
    $_SESSION = array();
    session_destroy();

    include $_SERVER['DOCUMENT_ROOT'] . '/views/logout/logout.html.php';
} else {
    header('Location: /');
}