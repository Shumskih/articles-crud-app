<?php

include $_SERVER['DOCUMENT_ROOT'] . '/helpers/connectToDB.php';

if (isset($_GET['deleteRole'])) {
    $userId = $_GET['id'];
    $roleId = $_POST['id'];

    try {
        $query = "DELETE FROM users_roles WHERE role_id = :roleId";
        $ps = $pdo->prepare($query);
        $ps->execute([
          'roleId' => $roleId
        ]);
    } catch (PDOException $e) {
        $e->getMessage();
    }

    header('Location: /users/edit-user?id=' . $userId);
}