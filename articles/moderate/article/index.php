<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/consts.php';
require_once ROOT . '/helpers/connectToDB.php';
require_once ROOT . '/helpers/monthsInRussian.php';
require_once ROOT . '/dao/ArticleDao.php';
require_once ROOT . '/dao/MessageDao.php';

$headTitle = '';

session_start();

if (isset($_POST['publish'])) {
  $articleId = intval($_POST['id']);
  ArticleDao::publishArticle($pdo, $articleId);

  header('Location: /');
}

if (isset($_GET['id']) && !isset($_POST['message'])
    && !isset($_POST['publish'])) {
  $articleId = intval($_GET['id']);
  $article = ArticleDao::getArticle($pdo, $articleId);

  $headTitle = $article['title'];

  // Convert english months to russian months
  $date = convertEngDateToRussian(strtotime($article['datetime']));

  include ROOT . '/views/articles/moderate/article.html.php';
}

if (isset($_POST['message'])) {
  $articleId = intval($_POST['id']);
  $message   = htmlspecialchars($_POST['messageBody'], ENT_QUOTES, 'UTF-8');
  $headTitle = 'Сообщение отправлено!';

  MessageDao::sendMessage($pdo, $message, $articleId);
  include ROOT . '/views/articles/moderate/success/success.html.php';
}