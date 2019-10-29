<?php

$tables = [
  'articles' => 'id                      int auto_increment primary key not null, 
                 title                   varchar(200)                   not null,
                 short_desc              varchar(500)                   not null,
                 body                    text                           not null,
                 img                     varchar(200)                       null,
                 datetime                datetime                       not null,
                 changed                 datetime,
                 published               boolean                        not null,
                 returned                boolean                        not null,
                 moderate                boolean                        not null',

  'categories' => 'id   int auto_increment primary key not null,
                   name varchar(500)',

  'categories_articles' => 'category_id int,
                            article_id  int,
                            foreign key (category_id) references categories (id),
                            foreign key (article_id) references articles (id)',

  'users' => 'id       int auto_increment primary key not null,
              name     varchar(200) not null,
              email    varchar(200) not null unique,
              password char(32)',

  'roles' => 'id          int auto_increment primary key not null,
              name        varchar(255),
              description varchar(255)',

  'users_roles' => 'user_id int not null,
                    role_id int not null,
                    foreign key (user_id) references users (id),
                    foreign key (role_id) references roles (id)',

  'users_articles' => 'user_id    int not null,
                       article_id int not null',
];

$relations = [
  'categoriesArticlesRelations' => [
    1 => [1, 2],
    2 => [3, 4],
    3 => [5, 6],
    4 => [7, 8],
    5 => [9, 10],
  ],
  'usersRolesRelations'         => [
    1 => [1, 2, 3, 4, 5],
    2 => [3],
    3 => [2],
  ],
  'usersArticlesRelations'      => [
    1 => [1, 3, 5],
    2 => [2, 4, 6],
    3 => [7, 8, 9, 10],
  ],
];

$users = [
  [
    'name'     => 'Shumskih',
    'email'    => 'shumskih@email.com',
    'password' => '6457773',
  ],
  [
    'name'     => 'Dimon',
    'email'    => 'dimon@email.com',
    'password' => 'password',
  ],
  [
    'name'     => 'Siri',
    'email'    => 'siri@apple.com',
    'password' => '5555555',
  ],
];

$roles = [
  [
    'name'        => 'Editor',
    'description' => 'Adding, deleting and editing articles',
  ],
  [
    'name'        => 'Account administrator',
    'description' => 'Adding, deleting and editing users',
  ],
  [
    'name'        => 'Site administrator',
    'description' => 'Adding, deleting and editing categories',
  ],
  [
    'name'        => 'Writer',
    'description' => 'User can write and edit his own articles',
  ],
  [
    'name'        => 'Moderator',
    'description' => 'Moderate articles. Approve or disapprove publication',
  ],
];