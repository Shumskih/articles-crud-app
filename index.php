<?php
require $_SERVER['DOCUMENT_ROOT'] . '/helpers/consts.php';
require ROOT . '/helpers/connectToDB.php';
require ROOT . '/helpers/monthsInRussian.php';
require ROOT . '/sql/queries.php';
require ROOT . '/dao/ArticleDao.php';

$articles = ArticleDao::getAllArticles($pdo);

$headTitle = 'Список статей';
$img       = ROOT . "/uploads/images/";

session_start();

include ROOT . '/views/articles/index.html.php';