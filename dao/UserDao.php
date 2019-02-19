<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sql/queries.php';

class UserDao
{
  public static function getUserBoundedToArticle(PDO $pdo, $articleId)
  {
    try {
      $query = GET_USER_BOUNDED_TO_ARTICLE;
      $doQuery = $pdo->prepare($query);
      $doQuery->execute([
        'articleId' => $articleId
      ]);
      return $doQuery->fetch();
    } catch (PDOException $e) {
      echo 'Can\'t get user bounded to article!<br>' . $e->getMessage();
    }
  }
}