<?php

require 'autoload.php';

function faker(PDO $pdo) {
    $tables = tablesList($pdo);
    $count = count($tables);

    if ($count > 0) {
        for ($i = $count - 1; $i >= 0; $i--) {
            dropTable($pdo, $tables[$i]);
        }
    }

    // Populate articles by fake data
    $columns = 'id         int auto_increment primary key not null,
                title      varchar(200)                   not null,
                short_desc varchar(500)                   not null,
                body       text                           not null,
                datetime   datetime                       not null,
                changed    datetime';
    createTable($pdo, 'articles', $columns);
    populateArticles($pdo);

    // Populate categories by fake data
    $columns = 'id   int auto_increment primary key not null,
                name varchar(500)';
    createTable($pdo, 'categories', $columns);
    populateCategories($pdo);

    // Add each article to category
    $columns = 'category_id int,
                article_id  int,
                foreign key (category_id) references categories (id),
                foreign key (article_id) references articles (id)';
    createTable($pdo, 'categories_articles', $columns);
    populateArticlesCategories($pdo);
}

function populateArticles(PDO $pdo) {
    $faker = Faker\Factory::create();

    for ($i = 0; $i < 10; $i++) {

        $articleTitle = $faker->sentence($nbWords = 6, $variableNbWords = true);
        $shortDesc = $faker->sentence($nbWords = 20, $variableNbWords = true);
        $bodyArr = $faker->paragraphs($nb = 5, $asText = false);
        $body = '';


        foreach ($bodyArr as $b) {
            $body .= $b . "<br>";
        }

        $query = 'INSERT INTO articles VALUES (null, :title, :short_desc, :body, now(), null)';
        $article = $pdo->prepare($query);
        $article->execute([
          'title' => $articleTitle,
          'short_desc' => $shortDesc,
          'body' => $body]);
    }
}

function populateCategories(PDO $pdo) {
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

function populateArticlesCategories(PDO $pdo) {
    $queryArticles = 'SELECT id FROM articles';
    $queryCategories = 'SELECT id FROM categories';

    $articlesIds = $pdo->query($queryArticles);
    $categoriesIds = $pdo->query($queryCategories);

    $articlesIdsArray = [];
    $categoriesIdsArray = [];

    while ($a = $articlesIds->fetch()) {
        array_push($articlesIdsArray, $a);
    }

    while ($c = $categoriesIds->fetch()) {
        array_push($categoriesIdsArray, $c);
    }

    for ($i = 0; $i < count($categoriesIdsArray) -1; $i++ ) {
        for ($j = 0; $j < 2; $j++) {
            echo $categoriesIdsArray[$i] . '<br>';
            echo $articlesIdsArray[$j] . '<br>';
            $query = "INSERT INTO categories_articles VALUES ($categoriesIdsArray[$i][0], $articlesIdsArray[$j][0])";
            $pdo->exec($query);
        }
    }
}

function isTableExists(PDO $pdo, string $table) : bool {
    try {
        $result = $pdo->query("SELECT * from $table LIMIT 1");
    } catch (Exception $e) {
        return false;
    }

    return $result !== false;
}

function dropTable(PDO $pdo, string $table) : bool {
    try {
        $result = $pdo->query("DROP TABLE $table");
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