<?php
include '../helpers/connectToDB.php';
include '../helpers/monthsInRussian.php';

$res = [];
$headTitle = '';

if(isset($_GET['id'])) {
    try {
        $query = 'SELECT id, title, body, datetime FROM articles WHERE id = :id';
        $article = $pdo->prepare($query);
        $article->execute(['id' => $_GET['id']]);
        $res = $article->fetch();

        $headTitle = $res['title'];

        // Convert english months to russian months
        $date = convertEngDateToRussian(strtotime($res['datetime']));
    } catch (PDOException $e) {
        echo 'Ошибка извлечения статьи из БД<br>' . $e->getMessage();
    }

    include '../views/articles/article.html.php';
}

if(isset($_POST['delete'])) {
    try {
        $query = 'DELETE from categories_articles WHERE article_id = :id';
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