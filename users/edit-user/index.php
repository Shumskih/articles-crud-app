<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/consts.php';
require_once ROOT . '/helpers/connectToDB.php';
require_once ROOT . '/dao/UserDao.php';
require_once ROOT . '/dao/RoleDao.php';

session_start();
$headTitle = 'Редактировать данные пользователя:';
if (isset($_POST['edit'])) {
  $userId      = $_POST['id'];
  $name        = $_POST['name'];
  $permissions = $_POST['permissions'];

  UserDao::unboundUserFromRoles($pdo, $userId);

  UserDao::updateUser($pdo, $userId, $name);

  UserDao::boundRoleToUser($pdo, $userId, $permissions);

  header('Location: /users');
}
if (isset($_GET['id'])) {
  $userId = $_GET['id'];
  $user   = UserDao::getUser($pdo, $userId);

  $userHasRoles = [];
  $userRoles    = RoleDao::getRolesOfUser($pdo, $user);

  foreach ($userRoles as $role) {
    array_unshift($userHasRoles, $role);
  }

  $allRoles = RoleDao::getRoles($pdo);
  include ROOT . '/views/users/edit-user/user.html.php';
}