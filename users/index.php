<?php

include $_SERVER['DOCUMENT_ROOT'] . '/helpers/connectToDB.php';

session_start();

if (!isset($_SESSION['account_administrator']))
    include $_SERVER['DOCUMENT_ROOT'] . '/views/denied/index.html.php';
else {
    $headTitle = 'Пользователи';

    $query = 'SELECT * FROM users';
    $doQuery = $pdo->query($query);
    $users = $doQuery->fetchAll();

    $roles = [];
    foreach ($users as $user) {
        $userId = $user['id'];
        $query = "SELECT users.id as userId, roles.name as roleName, roles.description as roleDescription FROM users
              INNER JOIN users_roles on users.id = users_roles.user_id
              INNER JOIN roles on roles.id = users_roles.role_id
              WHERE users.id = $userId";
        $doQuery = $pdo->query($query);
        while ($r = $doQuery->fetch())
            array_unshift($roles, [
              $r['userId'] => [
                'roleName' => $r['roleName'],
                'roleDescription' => $r['roleDescription']
              ]
            ]);
    }


    include $_SERVER['DOCUMENT_ROOT'] . '/views/users/users.html.php';
}