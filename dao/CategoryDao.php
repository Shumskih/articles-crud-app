<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sql/queries.php';

class CategoryDao
{
  public static function getAllCategories(PDO $pdo)
  {
    try {
      $query = GET_ALL_CATEGORIES;
      return $pdo->query($query);
    } catch (PDOException $e) {
      echo 'Can\'t get categories<br>' . $e->getMessage();
    }
  }
}