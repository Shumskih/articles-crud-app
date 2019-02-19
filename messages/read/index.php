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

  $query   = 'DELETE FROM categories_articles WHERE article_id = :articleId';
  $doQuery = $pdo->prepare($query);
  $doQuery->execute([
    'articleId' => $articleId,
  ]);

  $query   = 'DELETE FROM users_articles WHERE article_id = :articleId';
  $doQuery = $pdo->prepare($query);
  $doQuery->execute([
    'articleId' => $articleId,
  ]);

  $query   = 'DELETE FROM articles_messages WHERE article_id = :articleId';
  $doQuery = $pdo->prepare($query);
  $doQuery->execute([
    'articleId' => $articleId,
  ]);

  $query   = 'DELETE FROM articles WHERE id = :articleId';
  $doQuery = $pdo->prepare($query);
  $doQuery->execute([
    'articleId' => $articleId,
  ]);

  header('Location: /messages');
}