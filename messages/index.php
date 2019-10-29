<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/consts.php';
require_once ROOT . '/helpers/connectToDB.php';
require_once ROOT . '/dao/ArticleDao.php';

$headTitle = 'Сообщения от модераторов';

session_start();

if (isset($_SESSION['loggedIn']) && isset($_SESSION['writer'])) {
    $email = $_SESSION['email'];

    $articles = ArticleDao::getReturnedArticles($pdo, $email);

    include ROOT . '/views/messages/messages.html.php';
} else {
    include ROOT . '/views/denied/index.html.php';
}