<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/consts.php';
require_once ROOT . '/helpers/connectToDB.php';
require_once ROOT . '/dao/ArticleDao.php';
require_once ROOT . '/dao/CategoryDao.php';
require_once ROOT . '/helpers/UploadFile.php';

$headTitle = 'Добавить статью';

session_start();

if (isset($_SESSION['editor']) or isset($_SESSION['writer'])) {
    if(isset($_POST['submit'])) {
      // article
      $title = $_POST['title'];
      $short_desc = $_POST['short_desc'];
      $body = $_POST['body'];

      // id of category
      $categoryId = $_POST['category'];

      // id of user
      $userId = $_SESSION['user_id'];

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