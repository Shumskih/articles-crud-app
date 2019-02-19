<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/consts.php';
require_once ROOT . '/helpers/connectToDB.php';
require_once ROOT . '/dao/ArticleDao.php';
require_once ROOT . '/helpers/UploadFile.php';

session_start();

// Select from database article by id
if (isset($_GET['id'])) {
  $articleId = $_GET['id'];
  $userId    = $_SESSION['user_id'];

  $article = ArticleDao::getArticleWithUser($pdo);

  if ($article['userId'] == $userId || $_SESSION['editor']) {
    $headTitle  = 'Изменить статью';
    $title      = $article['title'];
    $short_desc = $article['short_desc'];
    $body       = $article['body'];

    include ROOT . '/views/articles/editArticle.html.php';
  } else {
    header('Location: /');
  }
}

if (isset($_POST['submit'])) {

  // article
  $id         = $_POST['id'];
  $title      = $_POST['title'];
  $short_desc = $_POST['short_desc'];
  $body       = $_POST['body'];

  // upload data
  $data = $_FILES['file'];

  // img dir
  $imgDir = "/uploads/images/";

  if ($data !== null) {
    $name = UploadFile::upload($pdo, $data);
  }



  // Update article
  if (isset($_SESSION['editor']) or isset($_SESSION['moderator'])) {
    ArticleDao::updateArticlePublished($pdo, $id, $title, $short_desc, $body, $name);

    header('Location: /');
  } else {
    ArticleDao::updateArticleUnpublished($pdo, $id, $title, $short_desc, $body, $name);

    include ROOT . '/views/articles/moderate/to-moderator.html.php';
  }
}