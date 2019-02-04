<?php
include '../../helpers/connectToDB.php';

$headTitle = 'Добавить статью';

session_start();

if (isset($_SESSION['editor']) or isset($_SESSION['writer'])) {
    if(isset($_POST['submit'])) {
        try {
            // article
            $title = $_POST['title'];
            $short_desc = $_POST['short_desc'];
            $body = $_POST['body'];

            // id of category
            $categoryId = $_POST['category'];

            // Upload image
            $imgDir = "/uploads/images/";
            @mkdir($imgDir, 0777);

            $data = $_FILES['file'];
            $tmp =$data['tmp_name'];

            if (is_uploaded_file($tmp)) {
                $info = @getimagesize($tmp);

                if (preg_match('{image/(.*)}is', $info['mime'], $p)) {
                    $name = "$imgDir" . time() . "." . $p[1];
                    move_uploaded_file($tmp, __DIR__ . "/" . $name);
                } else {
                    echo "<h2>Вы пы таетесь добавить файл недопустимого формата!</h2>";
                }
            } else {
                echo "<h2>Ошибка закачки #{$data['error']}!</h2>";
            }

            // Insert article to database
            $query = "INSERT INTO articles VALUES (null, :title, :short_desc, :body, :img, now(), null)";
            $article = $pdo->prepare($query);
            $article->execute([
              'title' => $title,
              'short_desc' => $short_desc,
              'body' => $body,
              'img' => $name
            ]);

            $articleId = $pdo->lastInsertId();

            $query = "INSERT INTO categories_articles VALUES (:categoryId, :articleId)";
            $res = $pdo->prepare($query);
            $res->execute([
              'categoryId' => $categoryId,
              'articleId' => $articleId
            ]);

            header('Location: /');
        } catch (PDOException $e) {
            echo 'Ошибка! Статья не добавлена!<br>' . $e->getMessage();

            include '../../views/articles/addArticle.html.php';
        }

    } else {
        $query = "SELECT * FROM categories ORDER BY name";
        $categories = $pdo->query($query);

        include '../../views/articles/addArticle.html.php';
    }
} else {
    include $_SERVER['DOCUMENT_ROOT'] . '/views/denied/index.html.php';
}


