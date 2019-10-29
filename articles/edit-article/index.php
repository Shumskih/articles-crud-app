<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/consts.php';
require_once ROOT . '/helpers/connectToDB.php';
require_once ROOT . '/dao/ArticleDao.php';
require_once ROOT . '/helpers/UploadFile.php';

session_start();

// Select from database article by id
if (isset($_GET['id'])) {
    $articleId = intval($_GET['id']);
    $userId    = intval($_SESSION['user_id']);

    $article = ArticleDao::getArticleWithUser($pdo, $articleId);

    if ($article['userId'] == $userId || $_SESSION['editor']) {
        $headTitle  = 'Изменить статью';
        $title      = htmlspecialchars($article['title'], ENT_QUOTES, 'UTF-8');
        $short_desc = htmlspecialchars($article['short_desc'], ENT_QUOTES, 'UTF-8');
        $body       = htmlspecialchars($article['body'], ENT_QUOTES, 'UTF-8');

        include ROOT . '/views/articles/editArticle.html.php';
    } else {
        header('Location: /');
    }
}

if (isset($_POST['submit'])) {

    // article
    $id         = intval($_POST['id']);
    $title      = htmlspecialchars($_POST['title'], ENT_QUOTES, 'UTF-8');
    $short_desc = htmlspecialchars($_POST['short_desc'], ENT_QUOTES, 'UTF-8');
    $body       = htmlspecialchars($_POST['body'], ENT_QUOTES, 'UTF-8');

    // upload data
    $data = $_FILES['file'];

    // img dir
    $imgDir = "/uploads/images/";

    if ($data !== null) {
        $name = UploadFile::upload($pdo, $data);
    }

    // Update article
    if (isset($_SESSION['editor']) or isset($_SESSION['moderator'])) {
        ArticleDao::updateArticlePublished($pdo, $id, $title, $short_desc, $body,
          $name);

        header('Location: /');
    } else {
        ArticleDao::updateArticleUnpublished($pdo, $id, $title, $short_desc, $body,
          $name);

        include ROOT . '/views/articles/moderate/to-moderator.html.php';
    }
}