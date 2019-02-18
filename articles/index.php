<?php
include '../helpers/connectToDB.php';
include '../helpers/monthsInRussian.php';

$res = [];
$headTitle = '';

session_start();

if(isset($_GET['id'])) {
    try {
        $query = 'SELECT articles.id as articleId, title, body, datetime, published, users.id as userId FROM articles
                  INNER JOIN users_articles on users_articles.article_id = articles.id
                  INNER JOIN users on users_articles.user_id = users.id
                  WHERE articles.id = :id';
        $article = $pdo->prepare($query);
        $article->execute(['id' => $_GET['id']]);
        $res = $article->fetch();

        $headTitle = $res['title'];

        // Convert english months to russian months
        $date = convertEngDateToRussian(strtotime($res['datetime']));
    } catch (PDOException $e) {
        echo 'Ошибка извлечения статьи из БД<br>' . $e->getMessage();
    }

    if ($res['published'] == 0)
        header('Location: /');
    else {
        include $_SERVER['DOCUMENT_ROOT'] . '/views/articles/article.html.php';
    }
}

if(isset($_POST['delete'])) {
    try {
        $query = 'DELETE from categories_articles WHERE article_id = :id';
        $article = $pdo->prepare($query);
        $article->execute([
          'id' => $_POST['id']
        ]);

        $query = 'DELETE from users_articles WHERE article_id = :id';
        $article = $pdo->prepare($query);
        $article->execute([
          'id' => $_POST['id']
        ]);

        $query = 'DELETE FROM articles WHERE id = :id';
        $article = $pdo->prepare($query);
        $article->execute([
          'id' => $_POST['id']
        ]);

        header('Location: /');
    } catch (PDOException $e) {
        echo 'Ошибка удаления статьи<br>' . $e->getMessage();
    }
}