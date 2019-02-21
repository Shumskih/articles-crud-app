<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sql/queries.php';

class RoleDao
{

  public static function getRoles(PDO $pdo)
  {
    try {
      $query   = GET_ROLES;
      $doQuery = $pdo->query($query);
      return $doQuery->fetchAll();
    } catch (PDOException $e) {
      echo 'Can\'t get roles!<br>' . $e->getMessage();
    }
  }

  public static function setRoleWriter(PDO $pdo, $userId, $roleId)
  {
    try {
      $query   = SET_ROLE_WRITER;
      $doQuery = $pdo->prepare($query);
      $doQuery->execute([
        'userId' => $userId,
        'roleId' => $roleId,
      ]);
    } catch (PDOException $e) {
      echo 'Can\'t set role writer!<br>' . $e->getMessage();
    }
  }

  public static function getRolesOfUsers(PDO $pdo, $user)
  {
    $roles = [];
    foreach ($user as $u) {
      $userId  = $u['id'];
      $query   = GET_ROLES_OF_USER;
      $doQuery = $pdo->prepare($query);
      $doQuery->execute([
        'userId' => $userId,
      ]);
      while ($r = $doQuery->fetch()) {
        array_unshift($roles, [
          $r['userId'] => [
            'roleName'        => $r['roleName'],
            'roleDescription' => $r['roleDescription'],
          ],
        ]);
      }
    }
    return $roles;
  }

  public static function getRolesOfUser(PDO $pdo, $user)
  {
    $userId  = $user['id'];
    $query        = GET_ROLES_OF_USER;
    $doQuery      = $pdo->prepare($query);
    $doQuery->execute([
      'userId' => $userId
    ]);

    return $doQuery->fetchAll();
  }

  public static function unboundRoleFromUser(PDO $pdo, $roleId)
  {
    try {
      $query = UNBOUND_ROLE_FROM_USER;
      $ps    = $pdo->prepare($query);
      $ps->execute([
        'roleId' => $roleId,
      ]);
    } catch (PDOException $e) {
      echo 'Can\'t unbound role from user!<br>' . $e->getMessage();
    }
  }
}