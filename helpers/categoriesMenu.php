<?php

$query = 'SELECT * FROM categories ORDER BY name';
$doQuery = $pdo->query($query);
$categories = $doQuery->fetchAll();