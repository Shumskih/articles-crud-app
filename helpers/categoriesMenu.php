<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/dao/CategoryDao.php';

$categories = CategoryDao::getAllCategories($pdo);