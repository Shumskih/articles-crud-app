<?php
include '../../helpers/connectToDB.php';

$headTitle = 'Добавить категорию';
global $success;
$unsuccess = '';

if(isset($_POST['submit'])) {

    try {
        $name = $_POST['name'];

        $query = "INSERT INTO categories VALUES (null, :name)";
        $category = $pdo->prepare($query);
        $isInsert = $category->execute([
          'name' => $name
        ]);

        if($isInsert)
            $success = 'Категория добавлена';

        header('Location: /categories');
    } catch (PDOException $e) {
        $unsuccess = 'Ошибка! Статья не добавлена!<br>' . $e->getMessage();

        header('Location: /categories/add-category');
    }

} else {
    include '../../views/categories/addCategory.html.php';
}


