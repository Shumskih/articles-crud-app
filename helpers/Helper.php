<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sql/queries.php';

class Helper
{

    public static function getPermissions(PDO $pdo, $userEmail)
    {
        try {
            $query   = GET_USER_PERMISSIONS;
            $doQuery = $pdo->prepare($query);
            $doQuery->execute([
              'email' => $userEmail,
            ]);
            return $doQuery->fetchAll();
        } catch (PDOException $e) {
            echo 'Can\'t get user permissions from database!' . $e->getMessage();
        }
    }

    public static function setPermissions(array $permissions)
    {
        foreach ($permissions as $permission) {
            if ($permission['id'] == 1) {
                $_SESSION['editor'] = true;
            }

            if ($permission['id'] == 2) {
                $_SESSION['account_administrator'] = true;
            }

            if ($permission['id'] == 3) {
                $_SESSION['site_administrator'] = true;
            }

            if ($permission['id'] == 4) {
                $_SESSION['writer'] = true;
            }

            if ($permission['id'] == 5) {
                $_SESSION['moderator'] = true;
            }

            $_SESSION['user_id'] = $permission['userId'];
        }
    }

    public static function deleteSession()
    {
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
              $params["path"], $params["domain"],
              $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
    }
}