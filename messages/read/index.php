<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/consts.php';
require_once ROOT . '/helpers/connectToDB.php';
require_once ROOT . '/helpers/monthsInRussian.php';
require_once ROOT . '/sql/queries.php';
require_once ROOT . '/dao/MessageDao.php';
require_once ROOT . '/dao/UserDao.php';

session_start();

if (isset($_GET['articleId']) && isset($_SESSION['loggedIn'])
    && isset($_SESSION['writer'])) {
  $articleId = $_GET['articleId'];
  $userId = $_SESSION['user_id'];

  $message = MessageDao::getMessageBoundedToArticle($pdo, $articleId);
  $user = UserDao::getUserBoundedToArticle($pdo, $articleId);

  $headTitle = $message['title'];

  // Convert english months to russian months
  $date = convertEngDateToRussian(strtotime($message['datetime']));
  include ROOT . '/views/messages/read/read.html.php';
}

if (isset($_POST['delete'])) {
  $articleId = $_POST['id'];

  ArticleDao::deleteArticleWithMessage($pdo, $articleId);
  header('Location: /messages');
}