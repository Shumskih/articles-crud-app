<?php

include $_SERVER['DOCUMENT_ROOT'] . '/helpers/connectToDB.php';

session_start();

$headTitle = 'Пользователи';

if (isset($_GET['search']) && $_GET['search'] !== '') {
    $name = $email = $_GET['search'];

    $query = "SELECT * FROM users WHERE name LIKE '%{$name}%' AND email LIKE '%{$email}%'";
    $doQuery = $pdo->query($query);
    $searchResults = $doQuery->fetchAll();

    $roles = [];
    foreach ($searchResults as $user) {
        $userId  = $user['id'];
        $query   = "SELECT users.id as userId, roles.name as roleName, roles.description as roleDescription FROM users
              INNER JOIN users_roles on users.id = users_roles.user_id
              INNER JOIN roles on roles.id = users_roles.role_id
              WHERE users.id = $userId";
        $doQuery = $pdo->query($query);
        while ($r = $doQuery->fetch()) {
            array_unshift($roles, [
              $r['userId'] => [
                'roleName'        => $r['roleName'],
                'roleDescription' => $r['roleDescription'],
              ],
            ]);
        }
    }

    $arrow = 'id';
    include $_SERVER['DOCUMENT_ROOT'] . '/views/users/search/result.html.php';
} elseif (isset($_GET['search']) && $_GET['search'] == '') {
    $message = 'error';
}

if (!isset($_SESSION['account_administrator'])) {
    include $_SERVER['DOCUMENT_ROOT'] . '/views/denied/index.html.php';
} elseif ((!isset($_GET['sort-by']) && !isset($_GET['search'])) or
          (!isset($_GET['sort-by']) && (isset($_GET['search'])) && $_GET['search'] == '')) {
    $query   = 'SELECT * FROM users';
    $doQuery = $pdo->query($query);
    $users   = $doQuery->fetchAll();

    $roles = [];
    foreach ($users as $user) {
        $userId  = $user['id'];
        $query   = "SELECT users.id as userId, roles.name as roleName, roles.description as roleDescription FROM users
              INNER JOIN users_roles on users.id = users_roles.user_id
              INNER JOIN roles on roles.id = users_roles.role_id
              WHERE users.id = $userId";
        $doQuery = $pdo->query($query);
        while ($r = $doQuery->fetch()) {
            array_unshift($roles, [
              $r['userId'] => [
                'roleName'        => $r['roleName'],
                'roleDescription' => $r['roleDescription'],
              ],
            ]);
        }
    }

    $arrow = 'id';
    include $_SERVER['DOCUMENT_ROOT'] . '/views/users/users.html.php';
}

if (isset($_SESSION['account_administrator']) && isset($_GET['sort-by']) && !isset($_GET['search'])
    && $_GET['sort-by'] == 'name') {

    $query   = 'SELECT * FROM users ORDER BY name';
    $doQuery = $pdo->query($query);
    $users   = $doQuery->fetchAll();

    $roles = [];
    foreach ($users as $user) {
        $userId  = $user['id'];
        $query   = "SELECT users.id as userId, roles.name as roleName, roles.description as roleDescription FROM users
              INNER JOIN users_roles on users.id = users_roles.user_id
              INNER JOIN roles on roles.id = users_roles.role_id
              WHERE users.id = $userId";
        $doQuery = $pdo->query($query);
        while ($r = $doQuery->fetch()) {
            array_unshift($roles, [
              $r['userId'] => [
                'roleName'        => $r['roleName'],
                'roleDescription' => $r['roleDescription'],
              ],
            ]);
        }
    }

    $arrow = 'name';
    include $_SERVER['DOCUMENT_ROOT'] . '/views/users/users.html.php';
}

if (isset($_SESSION['account_administrator']) && isset($_GET['sort-by']) && !isset($_GET['search'])
    && $_GET['sort-by'] == 'email') {

    $query   = 'SELECT * FROM users ORDER BY email';
    $doQuery = $pdo->query($query);
    $users   = $doQuery->fetchAll();

    $roles = [];
    foreach ($users as $user) {
        $userId  = $user['id'];
        $query   = "SELECT users.id as userId, roles.name as roleName, roles.description as roleDescription FROM users
              INNER JOIN users_roles on users.id = users_roles.user_id
              INNER JOIN roles on roles.id = users_roles.role_id
              WHERE users.id = $userId";
        $doQuery = $pdo->query($query);
        while ($r = $doQuery->fetch()) {
            array_unshift($roles, [
              $r['userId'] => [
                'roleName'        => $r['roleName'],
                'roleDescription' => $r['roleDescription'],
              ],
            ]);
        }
    }

    $arrow = 'email';
    include $_SERVER['DOCUMENT_ROOT'] . '/views/users/users.html.php';
}