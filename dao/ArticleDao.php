<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sql/queries.php';

class ArticleDao
{
  public static function getAllArticles(PDO $pdo)
  {
    try {
      $query = GET_ALL_PUBLISHED_ARTICLES;

      return $pdo->query($query);
    } catch (PDOException $e) {
      echo 'Fetch error!<br>' . $e->getMessage();
    }
  }

  public static function getArticle(PDO $pdo)
  {
    try {
      $query = GET_ARTICLE_AND_BOUND_USER;
      $article = $pdo->prepare($query);
      $article->execute(['id' => $_GET['id']]);

      return $article->fetch();
    } catch (PDOException $e) {
      echo 'Fetch error!<br>' . $e->getMessage();
    }
  }

  public static function insertArticlePublished(PDO $pdo, $title, $short_desc, $body, $name, $categoryId, $userId)
  {
    try {
      $query = INSERT_ARTICLE_PUBLISHED;
      $article = $pdo->prepare($query);
      $article->execute([
        'title' => $title,
        'short_desc' => $short_desc,
        'body' => $body,
        'img' => $name
      ]);
    } catch (PDOException $e) {
      echo 'Can\'t insert article to database<br>' . $e->getMessage();
    }

    $articleId = $pdo->lastInsertId();

    self::boundArticleToCategory($pdo, $categoryId, $articleId);
    self::boundArticleToUser($pdo, $userId, $articleId);
  }

  public static function insertArticleUnpublished(PDO $pdo, $title, $short_desc, $body, $name, $categoryId, $userId)
  {
    try {
      $query = INSERT_ARTICLE_UNPUBLISHED;
      $article = $pdo->prepare($query);
      $article->execute([
        'title' => $title,
        'short_desc' => $short_desc,
        'body' => $body,
        'img' => $name
      ]);
    } catch (PDOException $e) {
      echo 'Can\'t insert article to database<br>' . $e->getMessage();
    }

    $articleId = $pdo->lastInsertId();

    self::boundArticleToCategory($pdo, $categoryId, $articleId);
    self::boundArticleToUser($pdo, $userId, $articleId);
  }

  public static function deleteArticle(PDO $pdo)
  {
    self::unboundArticleFromCategory($pdo);
    self::unboundArticleFromUser($pdo);
    try {
      $query = DELETE_ARTICLE;
      $article = $pdo->prepare($query);
      $article->execute([
        'id' => $_POST['id']
      ]);

      return true;
    } catch (PDOException $e) {
      echo 'Delete error!<br>' . $e->getMessage();
      return false;
    }
  }

  public static function boundArticleToCategory(PDO $pdo, $categoryId, $articleId)
  {
    try {
      $query = BOUND_ARTICLE_TO_CATEGORY;
      $res = $pdo->prepare($query);
      $res->execute([
        'categoryId' => $categoryId,
        'articleId' => $articleId
      ]);
    } catch (PDOException $e) {
      echo 'Can\'t bound article to category' . $e->getMessage();
    }
  }

  public static function boundArticleToUser(PDO $pdo, $userId, $articleId)
  {
    try {
      $query = BOUND_ARTICLE_TO_USER;
      $res = $pdo->prepare($query);
      $res->execute([
        'userId' => $userId,
        'articleId' => $articleId
      ]);
    } catch (PDOException $e) {
      echo 'Can\'t bound article to user' . $e->getMessage();
    }
  }

  public static function unboundArticleFromCategory(PDO $pdo)
  {
    try {
      $query = UNBOUND_ARTICLE_FROM_CATEGORY;
      $article = $pdo->prepare($query);
      $article->execute([
        'id' => $_POST['id']
      ]);

      return true;
    } catch(PDOException $e) {
      echo 'Can\'t unbound article from category<br>' . $e->getMessage();
      return false;
    }
  }

  public static function unboundArticleFromUser(PDO $pdo)
  {
    try {
      $query = UNBOUND_ARTICLE_FROM_USER;
      $article = $pdo->prepare($query);
      $article->execute([
        'id' => $_POST['id']
      ]);

      return true;
    } catch(PDOException $e) {
      echo 'Can\'t unbound article from user<br>' . $e->getMessage();
      return false;
    }
  }
}