<?php

$query = 'SELECT * FROM categories';
$categories = $pdo->query($query);

$query = 'SELECT COUNT(*) from articles';
$count = $pdo->query($query);
$countRows = $count->fetchColumn();