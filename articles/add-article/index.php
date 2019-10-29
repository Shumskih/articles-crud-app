<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/consts.php';
require_once ROOT . '/helpers/connectToDB.php';
require_once ROOT . '/dao/ArticleDao.php';
require_once ROOT . '/dao/CategoryDao.php';
require_once ROOT . '/helpers/UploadFile.php';

$headTitle = 'Добавить статью';

session_start();

if (isset($_SESSION['editor']) or isset($_SESSION['writer'])) {
    if (isset($_POST['submit'])) {
        // article
        $title      = htmlspecialchars($_POST['title'], ENT_QUOTES, 'UTF-8');
        $short_desc = htmlspecialchars($_POST['short_desc'], ENT_QUOTES, 'UTF-8');
        $body       = htmlspecialchars($_POST['body'], ENT_QUOTES, 'UTF-8');

        // id of category
        $categoryId = intval($_POST['category']);

        // id of user
        $userId = intval($_SESSION['user_id']);

        // file
        $data = $_FILES['file'];

        // image dir
        $imgDir = "/uploads/images/";

        $name = UploadFile::upload($imgDir, $data);

        // Insert article to database
        if (isset($_SESSION['editor']) or isset($_SESSION['moderator'])) {
            ArticleDao::insertArticlePublished($pdo, $title, $short_desc, $body, $name, $categoryId, $userId);

            header('Location: /');
        } else {
            ArticleDao::insertArticleUnpublished($pdo, $title, $short_desc, $body, $name, $categoryId, $userId);

            include ROOT . '/views/articles/moderate/to-moderator.html.php';
        }
    } else {
        $categories = CategoryDao::getAllCategories($pdo);

        include ROOT . '/views/articles/addArticle.html.php';
    }
} else {
    include ROOT . '/views/denied/index.html.php';
}