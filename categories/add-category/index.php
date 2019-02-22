<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/consts.php';
require_once ROOT . '/helpers/connectToDB.php';
require_once ROOT . '/dao/CategoryDao.php';

$headTitle = 'Добавить категорию';

session_start();

if (isset($_SESSION['site_administrator'])) {
  if (isset($_POST['submit'])) {
    $categoryName = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');

    CategoryDao::addCategory($pdo, $categoryName);
    header('Location: /categories');
  } else {
    include ROOT . '/views/categories/addCategory.html.php';
  }
} else {
  include ROOT . '/views/denied/index.html.php';
}


