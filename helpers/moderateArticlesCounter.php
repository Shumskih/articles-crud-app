<?php

$query = 'SELECT COUNT(*) FROM articles WHERE moderate = 1';
$a = $pdo->query($query);
$moderateArticlesCount = $a->fetchColumn();

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];

    $query = 'SELECT COUNT(*) FROM articles
          INNER JOIN users_articles on users_articles.article_id = articles.id
          INNER JOIN users on users_articles.user_id = users.id
          WHERE email = :email AND returned = 1';
    $doQuery = $pdo->prepare($query);
    $doQuery->execute([
      'email' => $email
    ]);
    $returnedArticles = $doQuery->fetchColumn();
}