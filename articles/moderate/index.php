<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/consts.php';
require_once ROOT . '/helpers/connectToDB.php';
require_once ROOT . '/helpers/monthsInRussian.php';
require_once ROOT . '/dao/ArticleDao.php';

$headTitle = 'Статьи на модерацию';

$articles = ArticleDao::getAllArticlesForModerator($pdo);
$img = ROOT . "/uploads/images/";

session_start();

require_once ROOT . '/views/articles/moderate/articles.html.php';