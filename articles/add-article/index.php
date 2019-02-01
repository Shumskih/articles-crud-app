<?php
include '../../helpers/connectToDB.php';

$headTitle = 'Добавить статью';
global $success;
$unsuccess = '';

if(isset($_GET['submit'])) {

    try {
        $title = $_GET['title'];
        $short_desc = $_GET['short_desc'];
        $body = $_GET['body'];

        $query = "INSERT INTO articles VALUES (null, :title, :short_desc, :body, now(), null)";
        $article = $pdo->prepare($query);
        $isInsert = $article->execute([
          'title' => $title,
          'short_desc' => $short_desc,
          'body' => $body
        ]);

        if($isInsert)
            $success = 'Статья добавлена';

        header('Location: /');
    } catch (PDOException $e) {
        $unsuccess = 'Ошибка! Статья не добавлена!<br>' . $e->getMessage();

        include '../../views/articles/addArticle.html.php';
    }

} else {
    include '../../views/articles/addArticle.html.php';
}


