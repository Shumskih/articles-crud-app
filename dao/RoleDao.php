<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sql/queries.php';

class RoleDao
{
    public static function setRoleWriter(PDO $pdo, $userId, $roleId)
    {
      try {
        $query = SET_ROLE_WRITER;
        $doQuery = $pdo->prepare($query);
        $doQuery->execute([
          'userId' => $userId,
          'roleId' => $roleId
        ]);
      } catch (PDOException $e) {
        echo 'Can\'t set role writer!<br>' . $e->getMessage();
      }
    }
}