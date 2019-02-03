<?php
include '../../helpers/connectToDB.php';

session_start();

// Select from database article by id
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    try {
        $query   = 'SELECT title, short_desc, body FROM articles WHERE id = :id';
        $article = $pdo->prepare($query);
        $article->execute(['id' => $id]);
        $res = $article->fetch();

    } catch (PDOException $e) {
        echo 'Ошибка извлечения статьи из БД<br>' . $e->getMessage();
    }

    $headTitle  = 'Изменить статью';
    $title      = $res['title'];
    $short_desc = $res['short_desc'];
    $body       = $res['body'];

    include '../../views/articles/changeArticle.html.php';

}

if (isset($_POST['submit'])) {

    $id = $_POST['id'];
    $title = $_POST['title'];
    $short_desc = $_POST['short_desc'];
    $body = $_POST['body'];

        try {
            $query = 'UPDATE articles SET title = :title, short_desc = :short_desc, body = :body, changed = now() WHERE id = :id';
            $article = $pdo->prepare($query);
            $article->execute(['id' => $id, 'title' => $title, 'short_desc' => $short_desc, 'body' => $body]);

            header('Location: /articles?id=' . $id);
        } catch (PDOException $e) {
            echo 'Ошибка изменения статьи<br>' . $e->getMessage();
        }
}

if (isset($_POST['cancel'])) {
    $id = $_POST['id'];

    header('Location: /articles?id=' . $id);
}