<?php

function userIsLoggedIn(PDO $pdo)
{
    if (isset($_POST['action']) or $_POST['action'] == 'login') {

        $password = md5($_POST['password'] . 'php_and_mysql');
    }

    if (isset($_POST['action']) and $_POST['action'] == 'logout') {
        session_start();
        unset($_SESSION['loggedIn']);
        unset($_SESSION['email']);
        unset($_SESSION['password']);
        header('Location: .');
        exit();
    }

    session_start();
    if (isset($_SESSION['loggedIn'])) {
        return databaseContainsUser($pdo, $_SESSION['email'], $_SESSION['password']);
    }
}

function databaseContainsUser(PDO $pdo, string $email, string $password)
{
    try {
        $query = 'SELECT * FROM users WHERE email = :email AND password = :password';
        $user  = $pdo->prepare($query);
        $user->execute([
          'email'    => $email,
          'password' => $password,
        ]);
    } catch (PDOException $e) {
        $e->getMessage();
        exit();
    }

    $row = $user->fetch();

    if ($row[0] > 0) {
        return $row['name'];
    } else {
        return false;
    }
}

function userHasRole(PDO $pdo, $role)
{
    try {
        $query  = 'SELECT * FROM users
              INNER JOIN users_roles on users.id = user_id
              INNER JOIN roles on roles.id = role_id
              WHERE email = :email AND roles.id = :roleId';
        $result = $pdo->prepare($query);
        $result->execute([
          'email'  => $_SESSION['email'],
          'roleId' => $role,
        ]);
    } catch (PDOException $e) {
        $e->getMessage();
        exit();
    }

    $row = $result->fetch();

    if ($row[0] > 0) {
        return true;
    } else {
        return false;
    }
}

function databaseContainsEmail(PDO $pdo, string $email)
{
    try {
        $query = 'SELECT * FROM users WHERE email = :email';
        $user  = $pdo->prepare($query);
        $user->execute([
          'email' => $email,
        ]);
    } catch (PDOException $e) {
        $e->getMessage();
        exit();
    }

    $row = $user->fetch();

    if ($row[0] > 0) {
        return true;
    } else {
        return false;
    }
}