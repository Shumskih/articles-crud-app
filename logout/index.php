<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/consts.php';
require_once ROOT . '/helpers/connectToDB.php';
require_once ROOT . '/helpers/access.php';
require_once ROOT . '/helpers/Helper.php';

session_start();

if (isset($_GET['logout']) && isset($_SESSION['loggedIn'])) {
    $headTitle = 'Возвращайтесь ещё!';

    Helper::deleteSession();

    include ROOT . '/views/logout/logout.html.php';
} else {
    header('Location: /');
}