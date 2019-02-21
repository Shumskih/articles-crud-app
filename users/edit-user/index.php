<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/consts.php';
require_once ROOT . '/helpers/connectToDB.php';
require_once ROOT . '/dao/UserDao.php';
require_once ROOT . '/dao/RoleDao.php';

session_start();

$headTitle = 'Редактировать данные пользователя:';

if (isset($_POST['edit'])) {
  $userId = $_POST['id'];
  $name   = $_POST['name'];


  $query   = "DELETE FROM users_roles WHERE user_id = $userId";
  $doQuery = $pdo->query($query);

  $query   = 'UPDATE users SET name = :name WHERE id = :userId';
  $ps      = $pdo->prepare($query);
  $doQuery = $ps->execute([
    'userId' => $userId,
    'name'   => $name,
  ]);

  foreach ($_POST['permissions'] as $k => $v) {
    $query   = "INSERT INTO users_roles (user_id, role_id) VALUES ($userId, $k)";
    $doQuery = $pdo->query($query);
  }
  header('Location: /users');
}

if (isset($_GET['id'])) {
  $userId = $_GET['id'];

  $user = UserDao::getUser($pdo, $userId);

  $userHasRoles = RoleDao::getRolesOfUser($pdo, $user);

  $roles = RoleDao::getRoles($pdo);

  include ROOT . '/views/users/edit-user/user.html.php';
}