<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/helpers/consts.php';
require_once ROOT . '/helpers/connectToDB.php';
require_once ROOT . '/helpers/fillTables.php';
require_once ROOT . '/sql/createTablesData.php';
require_once ROOT . '/helpers/monthsInRussian.php';

session_start();

faker($pdo, $tables, $relations, $users, $roles);