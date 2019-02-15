<?php

include $_SERVER['DOCUMENT_ROOT'] . '/helpers/connectToDB.php';
include $_SERVER['DOCUMENT_ROOT'] . '/helpers/access.php';

$headTitle = 'Вход';

if (isset($_POST['submit'])) {

    if (!isset($_POST['email']) or $_POST['email'] == '' or
        !isset($_POST['password']) or $_POST['password'] == '') {

        $loginError = 'Необходимо заполнить все поля';

        include $_SERVER['DOCUMENT_ROOT'] . '/views/login/login.html.php';
    }

    $email = $_POST['email'];
    $password = md5($_POST['password'] . 'php_and_mysql');

    if ($name = databaseContainsUser($pdo, $email, $password)) {
        session_start();

        $email = $_POST['email'];
        $_SESSION['loggedIn'] = true;
        $_SESSION['email'] = $email;
        $_SESSION['password'] = $password;
        $_SESSION['name'] = $name;

        $query = 'SELECT roles.id FROM roles
                  INNER JOIN users_roles on roles.id = users_roles.role_id
                  INNER JOIN users on users_roles.user_id = users.id
                  WHERE email = :email';
        $permissions = $pdo->prepare($query);
        $permissions->execute([
            'email' => $email
        ]);

        while ($perm = $permissions->fetch()) {
            if ($perm['id'] == 1)
                $_SESSION['editor'] = true;

            if ($perm['id'] == 2)
                $_SESSION['account_administrator'] = true;

            if ($perm['id'] == 3)
                $_SESSION['site_administrator'] = true;

            if ($per['id'] = 4)
                $_SESSION['writer'] = true;

            if ($per['id'] = 5)
                $_SESSION['moderator'] = true;
        }

        unset($permissions);

        $redirectToMainPage = true;
        include $_SERVER['DOCUMENT_ROOT'] . '/views/login/success/success.html.php';
    } else {
        $loginError = 'Такой пользователь не зарегистрирован.';

        include $_SERVER['DOCUMENT_ROOT'] . '/views/login/login.html.php';
    }
} else {
    include $_SERVER['DOCUMENT_ROOT'] . '/views/login/login.html.php';
}
