<?php

include  $_SERVER['DOCUMENT_ROOT'] . '/helpers/connectToDB.php';
include  $_SERVER['DOCUMENT_ROOT'] . '/helpers/access.php';

session_start();

if (isset($_POST['register'])) {
    if (!isset($_POST['name']) or $_POST['name'] == '' or
        !isset($_POST['email']) or $_POST['email'] == '' or
        !isset($_POST['password']) or $_POST['password'] == '') {

        $GLOBALS['registerError'] = 'Необходимо заполнить все поля!';

        include $_SERVER['DOCUMENT_ROOT'] . '/views/registration/registration.html.php';
    }

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = md5($_POST['password'] . 'php_and_mysql');

    try {
        if(!databaseContainsEmail($pdo, $email)) {
            $_SESSION['loggedIn'] = true;
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
            $_SESSION['password'] = $password;
            $_SESSION['writer'] = true;

            $query = 'INSERT INTO users VALUES (null, :name, :email, :password)';
            $user = $pdo->prepare($query);
            $user->execute([
              'name' => $name,
              'email' => $email,
              'password' => $password
            ]);

            $userId = $pdo->lastInsertId();

            $query = "INSERT INTO users_roles VALUES ($userId, 4)";
            $user = $pdo->query($query);

            $redirectToMainPage = true;
            include $_SERVER['DOCUMENT_ROOT'] . '/views/registration/success/success.html.php';
        }
    } catch (PDOException $e) {
        $e->getMessage();
    }
} else {
    include $_SERVER['DOCUMENT_ROOT'] . '/views/registration/registration.html.php';
}