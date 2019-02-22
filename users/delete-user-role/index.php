<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/consts.php';
require_once ROOT . '/helpers/connectToDB.php';
require_once ROOT . '/dao/RoleDao.php';

if (isset($_GET['deleteRole'])) {
    $userId = intval($_GET['id']);
    $roleId = intval($_POST['id']);

    RoleDao::unboundRoleFromUser($pdo, $roleId);
    header('Location: /users/edit-user?id=' . $userId);
}