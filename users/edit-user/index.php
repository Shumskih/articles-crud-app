<?php

include $_SERVER['DOCUMENT_ROOT'] . '/helpers/connectToDB.php';

session_start();

$headTitle = 'Редактировать данные пользователя:';

if (isset($_POST['edit'])) {
    $userId = $_POST['id'];
    $name  = $_POST['name'];


    $query   = "DELETE FROM users_roles WHERE user_id = $userId";
    $doQuery = $pdo->query($query);

    $query = 'UPDATE users SET name = :name WHERE id = :userId';
    $ps = $pdo->prepare($query);
    $doQuery = $ps->execute([
      'userId' => $userId,
      'name' => $name
    ]);

    foreach ($_POST['permissions'] as $k => $v) {
        $query = "INSERT INTO users_roles (user_id, role_id) VALUES ($userId, $k)";
        $doQuery = $pdo->query($query);
    }

    header('Location: /users');
}

if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    $query = "SELECT * FROM users WHERE id = $userId";
    $doQuery = $pdo->query($query);
    $result = $doQuery->fetch();

    $userHasRoles = [];
    $query = "SELECT users.id as userId, roles.id as roleId, roles.name as roleName, roles.description as roleDescription FROM users
              INNER JOIN users_roles on users.id = users_roles.user_id
              INNER JOIN roles on roles.id = users_roles.role_id
              WHERE users.id = $userId";
    $doQuery = $pdo->query($query);
    $r = $doQuery->fetchAll();
    foreach ($r as $role) {
        array_unshift($userHasRoles, $role);
    }

    $query = "SELECT * FROM roles";
    $doQuery = $pdo->query($query);
    $allRoles = $doQuery->fetchAll();

    include $_SERVER['DOCUMENT_ROOT'] . '/views/users/edit-user/user.html.php';
}