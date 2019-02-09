<?php

include $_SERVER['DOCUMENT_ROOT'] . '/helpers/connectToDB.php';

if ($_GET['id']) {
    $userId = $_GET['id'];

    $query = "DELETE FROM users_roles WHERE user_id = $userId";
    $doQuery = $pdo->query($query);

    $query = "DELETE FROM users WHERE id = $userId";
    $doQuery = $pdo->query($query);

    header('Location: /users');
}