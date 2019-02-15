<?php

include $_SERVER['DOCUMENT_ROOT'] . '/helpers/connectToDB.php';
include $_SERVER['DOCUMENT_ROOT'] . '/helpers/access.php';

session_start();

if (isset($_GET['logout']) && isset($_SESSION['loggedIn'])) {
    $headTitle = 'Возвращайтесь ещё!';

    $_SESSION = array();
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
          $params["path"], $params["domain"],
          $params["secure"], $params["httponly"]
        );
    }

    session_destroy();

    include $_SERVER['DOCUMENT_ROOT'] . '/views/logout/logout.html.php';
} else {
    header('Location: /');
}