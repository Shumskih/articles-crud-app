<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/consts.php';
require_once ROOT . '/helpers/connectToDB.php';
require_once ROOT . '/dao/UserDao.php';
require_once ROOT . '/dao/RoleDao.php';

session_start();

$headTitle = 'Пользователи';

if (isset($_GET['search']) && $_GET['search'] !== '') {
  $name = $email = $_GET['search'];

  $user = UserDao::searchUserByNameAndEmail($pdo, $name, $email);

  $roles = RoleDao::getRolesOfUsers($pdo, $user);

  $arrow = 'id';
  include ROOT . '/views/users/search/result.html.php';
} elseif (isset($_GET['search']) && $_GET['search'] == '') {
  $message = 'error';
}

if (!isset($_SESSION['account_administrator'])) {
  include ROOT . '/views/denied/index.html.php';
} elseif ((!isset($_GET['sort-by']) && !isset($_GET['search'])) or
          (!isset($_GET['sort-by']) && (isset($_GET['search']))
           && $_GET['search'] == '')) {
  $users = UserDao::getUsers($pdo);

  $roles = RoleDao::getRolesOfUsers($pdo, $users);

  $arrow = 'id';
  include ROOT . '/views/users/users.html.php';
}

if (isset($_SESSION['account_administrator']) && isset($_GET['sort-by'])
    && !isset($_GET['search'])
    && $_GET['sort-by'] == 'name') {

  $users = UserDao::getUsersSortedByName($pdo);

  $roles = RoleDao::getRolesOfUser($pdo, $users);

  $arrow = 'name';
  include ROOT . '/views/users/users.html.php';
}

if (isset($_SESSION['account_administrator']) && isset($_GET['sort-by'])
    && !isset($_GET['search'])
    && $_GET['sort-by'] == 'email') {

  $users = UserDao::getUsersSortedByEmail($pdo);

  $roles = RoleDao::getRolesOfUser($pdo, $users);

  $arrow = 'email';
  include ROOT . '/views/users/users.html.php';
}