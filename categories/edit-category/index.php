<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/consts.php';
require_once ROOT . '/helpers/connectToDB.php';
require_once ROOT . '/dao/CategoryDao.php';

session_start();

if (isset($_POST['submit'])) {
    $categoryId   = intval($_POST['id']);
    $categoryName = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
    $headTitle    = $categoryName;

    CategoryDao::updateCategory($pdo, $categoryId, $categoryName);
    header('Location: /categories?id=' . $categoryId);
}

if (isset($_POST['cancel'])) {
    $categoryId = intval($_POST['id']);

    header('Location: /categories?id=' . $categoryId);
}

// Select from database category by id
if (isset($_GET['id']) && !isset($_SESSION['site_administrator'])) {
    include ROOT . '/views/denied/index.html.php';
} else {
    $headTitle    = 'Изменить категорию';
    $categoryId   = intval($_GET['id']);
    $category     = CategoryDao::getCategory($pdo, $categoryId);
    $categoryName = $category['name'];

    include ROOT . '/views/categories/editCategory.html.php';
}