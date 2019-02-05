<?php

include $_SERVER['DOCUMENT_ROOT'] . '/helpers/connectToDB.php';
include $_SERVER['DOCUMENT_ROOT'] . '/helpers/access.php';

session_start();

if (isset($_SESSION['loggedIn'])) {
    foreach ($_SESSION as $s)
        unset($s);
    $_SESSION = array();
    session_destroy();

    include $_SERVER['DOCUMENT_ROOT'] . '/views/logout/logout.html.php';
} else {
    header('Location: /');
}