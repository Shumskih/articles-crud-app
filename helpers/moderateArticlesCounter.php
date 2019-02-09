<?php

$query = 'SELECT COUNT(*) FROM articles WHERE moderate = true';
$a = $pdo->query($query);
$moderateArticlesCount = $a->fetchColumn();