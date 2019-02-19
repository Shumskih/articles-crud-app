<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/consts.php';
require_once ROOT . '/helpers/connectToDB.php';
require_once ROOT . '/dao/CategoryDao.php';
require_once ROOT . '/dao/ArticleDao.php';

session_start();

if (isset($_POST['delete'])) {
  $categoryId = $_POST['id'];

  CategoryDao::deleteCategory($pdo, $categoryId);
  header('Location: /categories');
}

if (!isset($_GET['id'])) {
  $headTitle = 'Категории';

  $categories = CategoryDao::getAllCategories($pdo);

  include ROOT . '/views/categories/index.html.php';
}

if (isset($_GET['id'])) {
  $categoryId = $_GET['id'];

  $articles = ArticleDao::getArticlesByCategory($pdo, $categoryId);

  $category = CategoryDao::getCategory($pdo, $categoryId);

  $categoryName = $category['name'];

  include ROOT . '/views/categories/category.html.php';
}