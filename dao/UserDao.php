<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sql/queries.php';

class UserDao
{

  public static function getUsers(PDO $pdo)
  {
    try {
      $query   = GET_USERS;
      $doQuery = $pdo->query($query);

      return $doQuery->fetchAll();
    } catch (PDOException $e) {
      echo 'Can\'t get users!<br>' . $e->getMessage();
    }
  }

  public static function getUsersSortedByName(PDO $pdo)
  {
    try {
      $query   = GET_USERS_SORTED_BY_NAME;
      $doQuery = $pdo->query($query);

      return $doQuery->fetchAll();
    } catch (PDOException $e) {
      echo 'Can\'t get users sorted by name!<br>' . $e->getMessage();
    }
  }

  public static function getUsersSortedByEmail(PDO $pdo)
  {
    try {
      $query   = GET_USERS_SORTED_BY_EMAIL;
      $doQuery = $pdo->query($query);

      return $doQuery->fetchAll();
    } catch (PDOException $e) {
      echo 'Can\'t get users sorted by name!<br>' . $e->getMessage();
    }
  }

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

  public static function searchUserByNameAndEmail(PDO $pdo, $name, $email)
  {
    try {
      $query = SEARCH_USER_BY_NAME_AND_EMAIL;
      $doQuery = $pdo->prepare($query);
      $doQuery->execute([
        'name' => $name,
        'email' => $email
      ]);
      return $doQuery->fetchAll();
    } catch (PDOException $e) {
      echo 'Can\'t search user!<br>' . $e->getMessage();
    }
  }

  public static function deleteUser(PDO $pdo, $userId)
  {
    self::unboundUserFromRoles($pdo, $userId);
    try {
      $query = DELETE_USER;
      $doQuery = $pdo->prepare($query);
      $doQuery->execute([
        'userId' => $userId
      ]);
    } catch (PDOException $e) {
      echo 'Can\'t delete user!<br>' . $e->getMessage();
    }
  }

  public static function unboundUserFromRoles(PDO $pdo, $userId)
  {
    try {
      $query = UNBOUND_USER_FROM_ROLES;
      $doQuery = $pdo->prepare($query);
      $doQuery->execute([
        'userId' => $userId
      ]);
    } catch (PDOException $e) {
      echo 'Can\'t unbound user from roles!<br>' . $e->getMessage();
    }
  }

  public static function getUser(PDO $pdo, $userId)
  {
    try {
      $query   = GET_USER;
      $doQuery = $pdo->prepare($query);
      $doQuery->execute([
        'userId' => $userId
      ]);

      return $doQuery->fetch();
    } catch (PDOException $e) {
      echo 'Can\'t get user!<br>' . $e->getMessage();
    }
  }
}