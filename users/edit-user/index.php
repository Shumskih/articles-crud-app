<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/consts.php';
require_once ROOT . '/helpers/connectToDB.php';
require_once ROOT . '/dao/UserDao.php';
require_once ROOT . '/dao/RoleDao.php';

session_start();
$headTitle = 'Редактировать данные пользователя:';
if (isset($_POST['edit'])) {
    $userId      = intval($_POST['id']);
    $name        = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
    $permissions = $_POST['permissions'];

    UserDao::unboundUserFromRoles($pdo, $userId);

    UserDao::updateUser($pdo, $userId, $name);

    UserDao::boundRoleToUser($pdo, $userId, $permissions);

    header('Location: /users');
}
if (isset($_GET['id'])) {
    $userId = intval($_GET['id']);
    $user   = UserDao::getUser($pdo, $userId);

    $userHasRoles = [];
    $userRoles    = RoleDao::getRolesOfUser($pdo, $user);

    foreach ($userRoles as $role) {
        array_unshift($userHasRoles, $role);
    }

    $allRoles = RoleDao::getRoles($pdo);
    include ROOT . '/views/users/edit-user/user.html.php';
}