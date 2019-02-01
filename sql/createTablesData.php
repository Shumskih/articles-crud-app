<?php

$tables = [
  'articles' => 'id         int auto_increment primary key not null,
                 title      varchar(200)                   not null,
                 short_desc varchar(500)                   not null,
                 body       text                           not null,
                 datetime   datetime                       not null,
                 changed    datetime',

  'categories' => 'id   int auto_increment primary key not null,
                   name varchar(500)',

  'categories_articles' => 'category_id int,
                            article_id  int,
                            foreign key (category_id) references categories (id),
                            foreign key (article_id) references articles (id)',
];

$relations = ['categoriesArticlesRelations' => [
  1 => [1, 2],
  2 => [3, 4],
  3 => [5, 6],
  4 => [7, 8],
  5 => [9, 10]
]
              ];