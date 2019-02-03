<?php

require 'autoload.php';

function faker(PDO $pdo, array $tables, array $relations, array $users, array $roles)
{
    $count = count($tables);

    if ($count > 0) {
        foreach ($tables as $table => $columns) {
            if (substr_count($table, '_') > 0) {
                dropTable($pdo, $table);
            }
        }

        foreach ($tables as $table => $columns) {
            dropTable($pdo, $table);
        }
    } else {
        echo 'В createTablesData.php нет таблиц!';
    }

    foreach ($tables as $table => $columns) {
        createTable($pdo, $table, $columns);

        if ($table == 'articles')
            populateArticles($pdo);

        if ($table == 'categories')
            populateCategories($pdo);

        if ($table == 'categories_articles')
            populateCategoriesArticles($pdo, $relations);

        if ($table == 'users')
            populateUsers($pdo, $users);

        if ($table == 'roles')
            populateRoles($pdo, $roles);

        if ($table == 'users_roles')
            populateUsersRoles($pdo, $relations);
    }
}

function populateArticles(PDO $pdo)
{
    $faker = Faker\Factory::create();

    for ($i = 0; $i < 10; $i++) {

        $articleTitle = $faker->sentence($nbWords = 6, $variableNbWords = true);
        $shortDesc = $faker->sentence($nbWords = 20, $variableNbWords = true);
        $bodyArr = $faker->paragraphs($nb = 5, $asText = false);
        $body = '';
        $img = '/uploads/images/1549124366.jpg';


        foreach ($bodyArr as $b) {
            $body .= $b . "<br>";
        }

        $query = 'INSERT INTO articles VALUES (null, :title, :short_desc, :body, :img, now(), null)';
        $article = $pdo->prepare($query);
        $article->execute([
          'title' => $articleTitle,
          'short_desc' => $shortDesc,
          'body' => $body,
          'img' => $img]);
    }
}

function populateCategories(PDO $pdo)
{
    $faker = Faker\Factory::create();

    for ($i = 0; $i < 5; $i++) {

        $categoryName = $faker->sentence($nbWords = 1, $variableNbWords = true);

        $query = 'INSERT INTO categories VALUES (null, :name)';
        $category = $pdo->prepare($query);
        $category->execute([
          'name' => $categoryName
        ]);
    }
}

function populateCategoriesArticles(PDO $pdo, array $relations)
{
    foreach ($relations['categoriesArticlesRelations'] as $category => $relations) {
        foreach ($relations as $r) {
            $query = "INSERT INTO categories_articles VALUES ($category, $r)";
            $pdo->query($query);
        }
    }
}

function populateUsers(PDO $pdo, array $users)
{
    foreach ($users as $user) {
        $name     = $user['name'];
        $email    = $user['email'];
        $password = md5($user['password'] . 'php_and_mysql');

        try {
            $query    = 'INSERT INTO users VALUES (null, :name, :email, :password)';
            $category = $pdo->prepare($query);
            $category->execute([
              'name'     => $name,
              'email'    => $email,
              'password' => $password,
            ]);
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }
}

function populateRoles(PDO $pdo, array $roles)
{
    foreach ($roles as $role) {
        $name     = $role['name'];
        $description    = $role['description'];

        try {
            $query    = 'INSERT INTO roles VALUES (null, :name, :description)';
            $category = $pdo->prepare($query);
            $category->execute([
              'name'        => $name,
              'description' => $description
            ]);
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }
}

function populateUsersRoles(PDO $pdo, array $relations)
{
    foreach ($relations['usersRolesRelations'] as $user => $relations) {
        foreach ($relations as $r) {
            $query = "INSERT INTO users_roles VALUES ($user, $r)";
            $pdo->query($query);
        }
    }
}

function isTableExists(PDO $pdo, string $table) : bool
{
    try {
        $result = $pdo->query("SELECT * from $table LIMIT 1");
    } catch (Exception $e) {
        return false;
    }

    return $result !== false;
}

function dropTable(PDO $pdo, string $table) : bool
{
    try {
        $result = $pdo->query("DROP TABLE IF EXISTS $table");
    } catch (PDOException $e) {
        $e->getMessage();
        return false;
    }

    return $result !== false;
}

function tablesList(PDO $pdo) {
    $query = 'SHOW TABLES';
    $tables = [];

    try {
        $query = $pdo->query($query);
    } catch (PDOException $e) {
        echo 'Ошибка извлечения списка таблиц';
    }

    while ($t = $query->fetch()) {
        array_push($tables, $t[0]);
    }

    return $tables;
}

function createTable(PDO $pdo, string $table, string $columns) {
    try {
        $query = "CREATE TABLE $table ($columns)";
        $pdo->query($query);
    } catch (PDOException $e) {
        echo "Не удалось создать таблицу $table<br>" . $e->getMessage();
    }
}