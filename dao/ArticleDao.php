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

    public static function getArticle(PDO $pdo, $articleId)
    {
        try {
            $query   = GET_ARTICLE;
            $article = $pdo->prepare($query);
            $article->execute(['id' => $articleId]);

            return $article->fetch();
        } catch (PDOException $e) {
            echo 'Can\'t get article' . $e->getMessage();
        }
    }

    public static function getArticleWithUser(PDO $pdo, $articleId)
    {
        try {
            $query   = GET_ARTICLE_AND_BOUNDED_USER;
            $article = $pdo->prepare($query);
            $article->execute(['id' => $articleId]);

            return $article->fetch();
        } catch (PDOException $e) {
            echo 'Fetch error!<br>' . $e->getMessage();
        }
    }

    public static function getAllArticlesForModerator(PDO $pdo)
    {
        try {
            $query = GET_ALL_ARTICLES_FOR_MODERATOR;

            return $pdo->query($query);
        } catch (PDOException $e) {
            echo 'Can\'t select articles for moderate' . $e->getMessage();
        }
    }

    public static function insertArticlePublished(
      PDO $pdo,
      $title,
      $short_desc,
      $body,
      $name,
      $categoryId,
      $userId
    ) {
        try {
            $query   = INSERT_ARTICLE_PUBLISHED;
            $article = $pdo->prepare($query);
            $article->execute([
              'title'      => $title,
              'short_desc' => $short_desc,
              'body'       => $body,
              'img'        => $name,
            ]);
        } catch (PDOException $e) {
            echo 'Can\'t insert article to database<br>' . $e->getMessage();
        }

        $articleId = $pdo->lastInsertId();

        self::boundArticleToCategory($pdo, $categoryId, $articleId);
        self::boundArticleToUser($pdo, $userId, $articleId);
    }

    public static function insertArticleUnpublished(
      PDO $pdo,
      $title,
      $short_desc,
      $body,
      $name,
      $categoryId,
      $userId
    ) {
        try {
            $query   = INSERT_ARTICLE_UNPUBLISHED;
            $article = $pdo->prepare($query);
            $article->execute([
              'title'      => $title,
              'short_desc' => $short_desc,
              'body'       => $body,
              'img'        => $name,
            ]);
        } catch (PDOException $e) {
            echo 'Can\'t insert article to database<br>' . $e->getMessage();
        }

        $articleId = $pdo->lastInsertId();

        self::boundArticleToCategory($pdo, $categoryId, $articleId);
        self::boundArticleToUser($pdo, $userId, $articleId);
    }

    public static function deleteArticle(PDO $pdo, $articleId)
    {
        self::unboundArticleFromCategory($pdo, $articleId);
        self::unboundArticleFromUser($pdo, $articleId);
        try {
            $query   = DELETE_ARTICLE;
            $article = $pdo->prepare($query);
            $article->execute([
              'id' => $_POST['id'],
            ]);

            return true;
        } catch (PDOException $e) {
            echo 'Delete error!<br>' . $e->getMessage();
            return false;
        }
    }

    public static function boundArticleToCategory(
      PDO $pdo,
      $categoryId,
      $articleId
    ) {
        try {
            $query = BOUND_ARTICLE_TO_CATEGORY;
            $res   = $pdo->prepare($query);
            $res->execute([
              'categoryId' => $categoryId,
              'articleId'  => $articleId,
            ]);
        } catch (PDOException $e) {
            echo 'Can\'t bound article to category<br>' . $e->getMessage();
        }
    }

    public static function boundArticleToUser(PDO $pdo, $userId, $articleId)
    {
        try {
            $query = BOUND_ARTICLE_TO_USER;
            $res   = $pdo->prepare($query);
            $res->execute([
              'userId'    => $userId,
              'articleId' => $articleId,
            ]);
        } catch (PDOException $e) {
            echo 'Can\'t bound article to user<br>' . $e->getMessage();
        }
    }

    public static function unboundArticleFromCategory(PDO $pdo, $articleId)
    {
        try {
            $query   = UNBOUND_ARTICLE_FROM_CATEGORY;
            $article = $pdo->prepare($query);
            $article->execute([
              'id' => $articleId,
            ]);

            return true;
        } catch (PDOException $e) {
            echo 'Can\'t unbound article from category<br>' . $e->getMessage();
            return false;
        }
    }

    public static function unboundArticleFromUser(PDO $pdo, $articleId)
    {
        try {
            $query   = UNBOUND_ARTICLE_FROM_USER;
            $article = $pdo->prepare($query);
            $article->execute([
              'id' => $articleId,
            ]);

            return true;
        } catch (PDOException $e) {
            echo 'Can\'t unbound article from user<br>' . $e->getMessage();
            return false;
        }
    }

    public static function updateArticleUnpublished(
      PDO $pdo,
      $id,
      $title,
      $short_desc,
      $body,
      $name
    ) {
        try {
            $query   = UPDATE_ARTICLE_UNPUBLISHED;
            $article = $pdo->prepare($query);
            $article->execute([
              'id'         => $id,
              'title'      => $title,
              'short_desc' => $short_desc,
              'body'       => $body,
              'img'        => $name,
            ]);
        } catch (PDOException $e) {
            echo 'Can\'t update article!<br>' . $e->getMessage();
        }
    }

    public static function updateArticlePublished(
      PDO $pdo,
      $id,
      $title,
      $short_desc,
      $body,
      $name
    ) {
        try {
            $query   = UPDATE_ARTICLE_PUBLISHED;
            $article = $pdo->prepare($query);
            $article->execute([
              'id'         => $id,
              'title'      => $title,
              'short_desc' => $short_desc,
              'body'       => $body,
              'img'        => $name,
            ]);
        } catch (PDOException $e) {
            echo 'Can\'t update article!<br>' . $e->getMessage();
        }
    }

    public static function publishArticle(PDO $pdo, $articleId)
    {
        try {
            $query   = PUBLISH_ARTICLE;
            $doQuery = $pdo->prepare($query);
            $doQuery->execute([
              'articleId' => $articleId,
            ]);
        } catch (PDOException $e) {
            echo 'Can\'t publish article<br>' . $e->getMessage();
        }
    }

    public static function returnArticle(PDO $pdo, $articleId)
    {
        try {
            $query   = RETURN_ARTICLE;
            $doQuery = $pdo->prepare($query);
            $doQuery->execute([
              'articleId' => $articleId,
            ]);
        } catch (PDOException $e) {
            echo 'Can\'t return article!<br>' . $e->getMessage();
        }
    }

    public static function getArticlesByCategory(PDO $pdo, $categoryId)
    {
        try {
            $query   = GET_ARTICLE_BY_CATEGORY;
            $doQuery = $pdo->prepare($query);
            $doQuery->execute([
              'categoryId' => $categoryId,
            ]);

            return $doQuery->fetchAll();
        } catch (PDOException $e) {
            echo 'Can\'t get articles by category!<br>' . $e->getMessage();
        }
    }

    public static function getReturnedArticles(PDO $pdo, $userEmail)
    {
        try {
            $query   = GET_RETURNED_ARTICLES;
            $doQuery = $pdo->prepare($query);
            $doQuery->execute([
              'email' => $userEmail,
            ]);

            return $doQuery->fetchAll();
        } catch (PDOException $e) {
            echo 'Can\'t get returned articles from database!<br>' . $e->getMessage();
        }
    }

    public static function deleteArticleWithMessage(PDO $pdo, $articleId)
    {
        self::unboundArticleFromMessage($pdo, $articleId);
        self::deleteArticle($pdo, $articleId);
    }

    public static function unboundArticleFromMessage(PDO $pdo, $articleId)
    {
        try {
            $query   = UNBOUND_ARTICLE_FROM_MESSAGE;
            $doQuery = $pdo->prepare($query);
            $doQuery->execute([
              'articleId' => $articleId,
            ]);
        } catch (PDOException $e) {
            echo 'Can\'t unbound article from message!<br>' . $e->getMessage();
        }
    }
}