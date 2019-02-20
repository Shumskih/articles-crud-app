<?php
require $_SERVER['DOCUMENT_ROOT'] . '/helpers/consts.php';
require ROOT . '/helpers/connectToDB.php';
require ROOT . '/helpers/monthsInRussian.php';
require ROOT . '/sql/queries.php';
require ROOT . '/dao/ArticleDao.php';

$res = [];
$headTitle = '';

session_start();

if(isset($_GET['id'])) {
  $article = ArticleDao::getArticleWithUser($pdo);

  $headTitle = $article['title'];

  // Convert english months to russian months
  $date = convertEngDateToRussian(strtotime($article['datetime']));

  if ($article['published'] == 0)
    header('Location: /');
  else {
    include ROOT . '/views/articles/article.html.php';
  }
}

if(isset($_POST['delete'])) {
  $articleId = $_POST['id'];

  ArticleDao::deleteArticle($pdo, $articleId);
  header('Location: /');
}