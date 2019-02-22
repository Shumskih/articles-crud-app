<?php
require $_SERVER['DOCUMENT_ROOT'] . '/helpers/consts.php';
require ROOT . '/helpers/connectToDB.php';
require ROOT . '/helpers/monthsInRussian.php';
require ROOT . '/sql/queries.php';
require ROOT . '/dao/ArticleDao.php';

$headTitle = '';

session_start();

if(isset($_GET['id'])) {
  $articleId = intval($_GET['id']);
  $article = ArticleDao::getArticleWithUser($pdo, $articleId);

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
  $articleId = intval($_POST['id']);

  ArticleDao::deleteArticle($pdo, $articleId);
  header('Location: /');
}