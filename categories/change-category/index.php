<?php
include '../../helpers/connectToDB.php';

// Select from database article by id
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    try {
        $query   = 'SELECT name FROM categories WHERE id = :id';
        $category = $pdo->prepare($query);
        $category->execute(['id' => $id]);
        $res = $category->fetch();

    } catch (PDOException $e) {
        echo 'Ошибка извлечения категории из БД<br>' . $e->getMessage();
    }

    $headTitle  = 'Изменить категорию';
    $name       = $res['name'];

    include '../../views/categories/changeCategory.html.php';

}

if (isset($_POST['submit'])) {

    $id = $_POST['id'];
    $name = $_POST['name'];
    $headTitle = $name;

    try {
        $query = 'UPDATE categories SET name = :name WHERE id = :id';
        $category = $pdo->prepare($query);
        $category->execute(['id' => $id, 'name' => $name]);

        header('Location: /categories?id=' . $id);
    } catch (PDOException $e) {
        echo 'Ошибка изменения категории<br>' . $e->getMessage();
    }
}

if (isset($_POST['cancel'])) {
    $id = $_POST['id'];

    header('Location: /categories?id=' . $id);
}
