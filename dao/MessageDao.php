<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/consts.php';
require_once ROOT . '/sql/queries.php';
require_once ROOT . '/dao/ArticleDao.php';

class MessageDao
{
  public static function sendMessage(PDO $pdo, $message, $articleId)
  {
    try {
      $query   = SEND_MESSAGE;
      $doQuery = $pdo->prepare($query);
      $doQuery->execute([
        'message' => $message,
      ]);

      $messageId = $pdo->lastInsertId();
    } catch (\PDOException $e) {
      echo 'Can\'t send message' . $e->getMessage();
    }
    self::boundMessageAndArticle($pdo, $messageId, $articleId);
    ArticleDao::returnArticle($pdo, $articleId);
  }

  public static function boundMessageAndArticle(PDO $pdo, $messageId, $articleId)
  {
    $query   = BOUND_ARTICLE_AND_MESSAGE;
    $doQuery = $pdo->prepare($query);
    $doQuery->execute([
      'articleId' => $articleId,
      'messageId' => $messageId,
    ]);
  }

  public static function getMessageBoundedToArticle(PDO $pdo, $articleId)
  {
    try {
      $query   = GET_MESSAGE_BOUNDED_TO_ARTICLE;
      $doQuery = $pdo->prepare($query);
      $doQuery->execute([
        'articleId' => $articleId
      ]);

      return $doQuery->fetch();
    } catch (PDOException $e) {
      echo 'Can\'t get message bounded to article!<br>' . $e->getMessage();
    }
  }
}