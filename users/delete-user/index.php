<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/consts.php';
require_once ROOT . '/helpers/connectToDB.php';
require_once ROOT . '/dao/UserDao.php';

if ($_GET['id']) {
    $userId = $_GET['id'];

    UserDao::deleteUser($pdo, $userId);
    header('Location: /users');
}