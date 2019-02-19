<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/consts.php';
require_once ROOT . '/helpers/connectToDB.php';
require_once ROOT . '/helpers/access.php';
require_once ROOT . '/helpers/Helper.php';

$headTitle = 'Вход';

if (isset($_POST['submit'])) {

  if (!isset($_POST['email']) or $_POST['email'] == '' or
      !isset($_POST['password']) or $_POST['password'] == '') {

    $loginError = 'Необходимо заполнить все поля';

    include ROOT . '/views/login/login.html.php';
  }

  $email    = $_POST['email'];
  $password = md5($_POST['password'] . 'php_and_mysql');

  if ($name = databaseContainsUser($pdo, $email, $password)) {
    session_start();

    $email                = $_POST['email'];
    $_SESSION['loggedIn'] = true;
    $_SESSION['email']    = $email;
    $_SESSION['password'] = $password;
    $_SESSION['name']     = $name;

    $permissions = Helper::getPermissions($pdo, $email);

    Helper::setPermissions($permissions);

    $redirectToMainPage = true;
    include ROOT . '/views/login/success/success.html.php';
  } else {
    $loginError = 'Такой пользователь не зарегистрирован.';

    include ROOT . '/views/login/login.html.php';
  }
} else {
  include ROOT . '/views/login/login.html.php';
}