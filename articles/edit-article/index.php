<?php
include '../../helpers/connectToDB.php';

session_start();

// Select from database article by id
if (isset($_GET['id'])) {
    $articleId = $_GET['id'];
    $userId = $_SESSION['user_id'];
    try {
        $query   = 'SELECT articles.id as articleId, title, short_desc, body, datetime, users.id as userId 
                    FROM articles
                    INNER JOIN users_articles on users_articles.article_id = articles.id
                    INNER JOIN users on users_articles.user_id = users.id
                    WHERE articles.id = :id';
        $article = $pdo->prepare($query);
        $article->execute(['id' => $articleId]);
        $res = $article->fetch();

    } catch (PDOException $e) {
        echo 'Ошибка извлечения статьи из БД<br>' . $e->getMessage();
    }

    if ($res['userId'] == $userId || $_SESSION['editor']) {
        $headTitle  = 'Изменить статью';
        $title      = $res['title'];
        $short_desc = $res['short_desc'];
        $body       = $res['body'];

        include $_SERVER['DOCUMENT_ROOT'] . '/views/articles/editArticle.html.php';
    } else {
        header('Location: /');
    }
}

if (isset($_POST['submit'])) {

    $id         = $_POST['id'];
    $title      = $_POST['title'];
    $short_desc = $_POST['short_desc'];
    $body       = $_POST['body'];

    try {
        // article
        $title = $_POST['title'];
        $short_desc = $_POST['short_desc'];
        $body = $_POST['body'];

        // id of category
        $categoryId = $_POST['category'];

        // id of user
        $userId = $_SESSION['user_id'];

        // Upload image
        $imgDir = "/uploads/images/";
        @mkdir($imgDir, 0777);

        $data = $_FILES['file'];
        $tmp =$data['tmp_name'];

        if (is_uploaded_file($tmp)) {
            $info = @getimagesize($tmp);

            if (preg_match('{image/(.*)}is', $info['mime'], $p)) {
                $name = "$imgDir" . time() . "." . $p[1];
                move_uploaded_file($tmp, $_SERVER['DOCUMENT_ROOT'] . '/' . $name);
            } else {
                echo "<h2>Вы пытаетесь добавить файл недопустимого формата!</h2>";
            }
        } else {
            echo "<h2>Ошибка закачки #{$data['error']}!</h2>";
        }

        // Insert article to database
        if (isset($_SESSION['editor']) or isset($_SESSION['moderator'])) {
            $query = "UPDATE articles 
                      SET title = :title, short_desc = :short_desc, body = :body, img = :img, 
                          changed = now(), published = true, returned = false, 
                          moderate = false, comments_of_moderator = null 
                      WHERE id = :id";
            $article = $pdo->prepare($query);
            $article->execute([
              'id' => $id,
              'title' => $title,
              'short_desc' => $short_desc,
              'body' => $body,
              'img' => $name
            ]);

            header('Location: /');
        } else {
            $query = "UPDATE articles 
                      SET title = :title, short_desc = :short_desc, body = :body, img = :img, 
                          changed = now(), published = false, returned = false, moderate = true, comments_of_moderator = null 
                      WHERE id = :id";
            $article = $pdo->prepare($query);
            $article->execute([
              'id' => $id,
              'title' => $title,
              'short_desc' => $short_desc,
              'body' => $body,
              'img' => $name
            ]);

            include $_SERVER['DOCUMENT_ROOT'] . '/views/articles/moderate/to-moderator.html.php';
        }
    } catch (PDOException $e) {
        echo 'Ошибка! Статья не добавлена!<br>' . $e->getMessage();

        include $_SERVER['DOCUMENT_ROOT'] . '/views/articles/addArticle.html.php';
    }
}