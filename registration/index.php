<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/consts.php';
require_once ROOT . '/helpers/connectToDB.php';
require_once ROOT . '/helpers/access.php';
require_once ROOT . '/dao/UserDao.php';
require_once ROOT . '/dao/RoleDao.php';

session_start();

if (isset($_POST['register'])) {
    if (!isset($_POST['name']) or $_POST['name'] == '' or
        !isset($_POST['email']) or $_POST['email'] == '' or
        !isset($_POST['password']) or $_POST['password'] == '') {

        $GLOBALS['registerError'] = 'Необходимо заполнить все поля!';

        include ROOT . '/views/registration/registration.html.php';
    }

    $name     = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
    $email    = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
    $password = md5(
      htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8') . 'php_and_mysql'
    );

    if (!databaseContainsEmail($pdo, $email)) {
        $_SESSION['loggedIn'] = true;
        $_SESSION['name']     = $name;
        $_SESSION['email']    = $email;
        $_SESSION['writer']   = true;

        $userId = UserDao::registerNewUser($pdo, $name, $email, $password);

        RoleDao::setRoleWriter($pdo, $userId, $roleId = 4);

        $redirectToMainPage = true;
        include ROOT . '/views/registration/success/success.html.php';
    }
} else {
    include ROOT . '/views/registration/registration.html.php';
}