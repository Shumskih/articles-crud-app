<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/sql/queries.php';

class CategoryDao
{

    public static function getAllCategories(PDO $pdo)
    {
        try {
            $query   = GET_ALL_CATEGORIES;
            $doQuery = $pdo->query($query);

            return $doQuery->fetchAll();
        } catch (PDOException $e) {
            echo 'Can\'t get categories<br>' . $e->getMessage();
        }
    }

    public static function getCategory(PDO $pdo, $categoryId)
    {
        try {
            $query   = GET_CATEGORY;
            $doQuery = $pdo->prepare($query);
            $doQuery->execute(['id' => $categoryId]);

            return $doQuery->fetch();
        } catch (PDOException $e) {
            echo 'Can\'t get category from database!<br>' . $e->getMessage();
        }
    }

    public static function addCategory(PDO $pdo, $categoryName)
    {
        try {
            $query    = INSERT_CATEGORY;
            $category = $pdo->prepare($query);
            $isInsert = $category->execute([
              'name' => $categoryName,
            ]);
        } catch (PDOException $e) {
            echo 'Error to add category!<br>' . $e->getMessage();
        }
    }

    public static function deleteCategory(PDO $pdo, $categoryId)
    {
        try {
            $query   = DELETE_CATEGORY;
            $doQuery = $pdo->prepare($query);
            $doQuery->execute(['id' => $categoryId]);
        } catch (PDOException $e) {
            echo 'Can\'t delete category<br>' . $e->getMessage();
        }
        self::unboundCategoryFromArticle($pdo, $categoryId);
    }

    public static function unboundCategoryFromArticle(PDO $pdo, $categoryId)
    {
        try {
            $query   = UNBOUND_CATEGORY_FROM_ARTICLE;
            $doQuery = $pdo->prepare($query);
            $doQuery->execute(['id' => $categoryId]);
        } catch (PDOException $e) {
            echo 'Can\'t unbound category from article<br>' . $e->getMessage();
        }
    }

    public static function updateCategory(PDO $pdo, $categoryId, $categoryName)
    {
        try {
            $query   = UPDATE_CATEGORY;
            $doQuery = $pdo->prepare($query);
            $doQuery->execute([
              'id'   => $categoryId,
              'name' => $categoryName,
            ]);
        } catch (PDOException $e) {
            echo 'Can\'t update category<br>' . $e->getMessage();
        }
    }
}