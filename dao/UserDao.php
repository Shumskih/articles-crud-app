<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sql/queries.php';

class UserDao
{

  public static function getUserBoundedToArticle(PDO $pdo, $articleId)
  {
    try {
      $query   = GET_USER_BOUNDED_TO_ARTICLE;
      $doQuery = $pdo->prepare($query);
      $doQuery->execute([
        'articleId' => $articleId,
      ]);
      return $doQuery->fetch();
    } catch (PDOException $e) {
      echo 'Can\'t get user bounded to article!<br>' . $e->getMessage();
    }
  }

  public static function registerNewUser(PDO $pdo, $name, $email, $password)
  {
    try {
      $query = INSERT_NEW_USER;
      $user  = $pdo->prepare($query);
      $user->execute([
        'name'     => $name,
        'email'    => $email,
        'password' => $password,
      ]);

      return $pdo->lastInsertId();
    } catch (PDOException $e) {
      echo 'Can\'t register new user!<br>' . $e->getMessage();
    }
  }
}