<?php
include '../helpers/connectToDB.php';

$headTitle = '';
$categoriesArr = [];

if (!isset($_GET['id'])) {
    $headTitle = 'Категории';

    try {
        $query = 'SELECT id, name FROM categories ORDER BY name';
        $categories = $pdo->query($query);

        while($cat = $categories->fetch())
            array_push($categoriesArr, [
              'id' => $cat['id'],
              'name' => $cat['name']
            ]);
    } catch (PDOException $e) {
        echo 'Ошибка извлечения категорий из базы данных<br>' . $e->getMessage();
    }

    include '../views/categories/index.html.php';
}

if(isset($_GET['id'])) {
    $categoryId = $_GET['id'];
    $articlesArr = [];

    try {
        $query = "SELECT title, short_desc FROM articles
                  LEFT JOIN categories_articles on articles.id = categories_articles.article_id
                  LEFT JOIN categories on categories_articles.category_id = categories.id
                  WHERE categories.id = $categoryId";
        $res = $pdo->query($query);

        while($article = $res->fetch()) {
            array_push($articlesArr, [
              'title' => $article['title'],
              'short_desc' => $article['short_desc']
            ]);
        }
    } catch (PDOException $e) {
        $e->getMessage();
    }

    try {
        $query = 'SELECT id, name FROM categories WHERE id = :id';
        $category = $pdo->prepare($query);
        $category->execute(['id' => $categoryId]);
        $res = $category->fetch();

        $headTitle = $res['name'];
    } catch (PDOException $e) {
        echo 'Ошибка извлечения категории из БД<br>' . $e->getMessage();
    }

    include '../views/categories/category.html.php';
}

if(isset($_POST['delete'])) {
    try {
        $queryCatsArticles = 'DELETE FROM categories_articles WHERE category_id = :id';
        $res = $pdo->prepare($queryCatsArticles);
        $res->execute(['id' => $_POST['id']]);

        $query = 'DELETE FROM categories WHERE id = :id';
        $category = $pdo->prepare($query);
        $category->execute(['id' => $_POST['id']]);

        header('Location: /categories');
    } catch (PDOException $e) {
        echo 'Ошибка удаления категории<br>' . $e->getMessage();
    }
}