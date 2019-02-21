<?php

// articles
const GET_ALL_PUBLISHED_ARTICLES = 'SELECT * FROM articles 
                                    WHERE published = 1 ORDER BY datetime DESC';

const GET_ALL_ARTICLES_FOR_MODERATOR = 'SELECT id, title, short_desc, img, datetime 
                                   FROM articles 
                                   WHERE moderate = true 
                                   ORDER BY datetime 
                                   ASC';

const GET_ARTICLE = 'SELECT id, title, body, datetime 
                     FROM articles 
                     WHERE id = :id';

const GET_ARTICLE_AND_BOUNDED_USER = 'SELECT articles.id as articleId, title, short_desc, body, datetime, published, users.id as userId 
                                      FROM articles
                                      INNER JOIN users_articles on users_articles.article_id = articles.id
                                      INNER JOIN users on users_articles.user_id = users.id
                                      WHERE articles.id = :id';

const UPDATE_ARTICLE_PUBLISHED = 'UPDATE articles 
                                  SET title = :title, short_desc = :short_desc, body = :body, img = :img, 
                                      changed = now(), published = true, returned = false, 
                                      moderate = false, comments_of_moderator = null 
                                  WHERE id = :id';

const UPDATE_ARTICLE_UNPUBLISHED = 'UPDATE articles 
                                    SET title = :title, short_desc = :short_desc, body = :body, img = :img, 
                                        changed = now(), published = false, returned = false, 
                                        moderate = true, comments_of_moderator = null 
                                    WHERE id = :id';

const PUBLISH_ARTICLE = 'UPDATE articles 
                         SET published = 1, returned = 0, moderate = 0 
                         WHERE id = :articleId';

const RETURN_ARTICLE = 'UPDATE articles 
                        SET returned = 1, moderate = 0 
                        WHERE id = :articleId';

const DELETE_ARTICLE = 'DELETE FROM articles 
                        WHERE id = :id';

const UNBOUND_ARTICLE_FROM_CATEGORY = 'DELETE from categories_articles 
                                       WHERE article_id = :id';

const UNBOUND_ARTICLE_FROM_USER = 'DELETE from users_articles 
                                   WHERE article_id = :id';

const UNBOUND_ARTICLE_FROM_MESSAGE = 'DELETE FROM articles_messages WHERE article_id = :articleId';

const INSERT_ARTICLE_PUBLISHED = 'INSERT INTO articles 
                                  VALUES (null, :title, :short_desc, :body, :img, now(), null, true, false, false, null)';

const INSERT_ARTICLE_UNPUBLISHED = 'INSERT INTO articles 
                                    VALUES (null, :title, :short_desc, :body, :img, now(), null, false, false, true, null)';

const BOUND_ARTICLE_TO_CATEGORY = 'INSERT INTO categories_articles 
                                   VALUES (:categoryId, :articleId)';

const BOUND_ARTICLE_TO_USER = 'INSERT INTO users_articles 
                               VALUES (:userId, :articleId)';

const BOUND_ARTICLE_AND_MESSAGE = 'INSERT INTO articles_messages 
                                   VALUES (:articleId, :messageId)';

const GET_ARTICLE_BY_CATEGORY = 'SELECT articles.id, title, short_desc, published 
                                 FROM articles
                                 LEFT JOIN categories_articles on articles.id = categories_articles.article_id
                                 LEFT JOIN categories on categories_articles.category_id = categories.id
                                 WHERE categories.id = :categoryId 
                                 AND published != 0';

const GET_RETURNED_ARTICLES = 'SELECT articles.id, title 
                               FROM articles
                               INNER JOIN users_articles on users_articles.article_id = articles.id
                               INNER JOIN users on users_articles.user_id = users.id
                               WHERE email = :email AND returned = 1';

// categories
const GET_ALL_CATEGORIES = 'SELECT * FROM categories 
                            ORDER BY name';

const GET_CATEGORY = 'SELECT * 
                      FROM categories 
                      WHERE id = :id';

const INSERT_CATEGORY = 'INSERT INTO categories 
                         VALUES (null, :name)';

const DELETE_CATEGORY = 'DELETE FROM categories 
                         WHERE id = :id';

const UPDATE_CATEGORY = 'UPDATE categories 
                         SET name = :name 
                         WHERE id = :id';

const UNBOUND_CATEGORY_FROM_ARTICLE = 'DELETE FROM categories_articles 
                                       WHERE category_id = :id';

// messages
const GET_USERS = 'SELECT * FROM users';

const GET_USERS_SORTED_BY_NAME = 'SELECT * FROM users ORDER BY name';

const GET_USERS_SORTED_BY_EMAIL = 'SELECT * FROM users ORDER BY email';

const SEND_MESSAGE = 'INSERT INTO messages 
                      VALUES (NULL, :message)';

// users
const GET_USER = 'SELECT * FROM users 
                  WHERE id = :userId';

const GET_USER_PERMISSIONS = 'SELECT roles.id, users.id as userId 
                              FROM roles
                              INNER JOIN users_roles on  users_roles.role_id = roles.id
                              INNER JOIN users on users_roles.user_id = users.id
                              WHERE email = :email';

const GET_USER_BOUNDED_TO_ARTICLE = 'SELECT users.id as userId 
                                     FROM users
                                     INNER JOIN users_articles on users_articles.user_id = users.id
                                     INNER JOIN articles on users_articles.article_id = articles.id
                                     WHERE articles.id = :articleId';

const GET_MESSAGE_BOUNDED_TO_ARTICLE = 'SELECT message, articles.id, title, short_desc, body, img, datetime 
                     FROM messages
                     INNER JOIN articles_messages on articles_messages.message_id = messages.id
                     INNER JOIN articles on articles_messages.article_id = articles.id
                     WHERE articles.id = :articleId';

const INSERT_NEW_USER = 'INSERT INTO users 
                         VALUES (null, :name, :email, :password)';

const SEARCH_USER_BY_NAME_AND_EMAIL = 'SELECT * FROM users WHERE name LIKE \%:name\% AND email LIKE \%:email\%';

const GET_ROLES_OF_USER = 'SELECT users.id as userId, roles.name as roleName, roles.description as roleDescription 
                           FROM users
                           INNER JOIN users_roles on users.id = users_roles.user_id
                           INNER JOIN roles on roles.id = users_roles.role_id
                           WHERE users.id = :userId';

const UNBOUND_USER_FROM_ROLES = 'DELETE FROM users_roles 
                                 WHERE user_id = :userId';

const DELETE_USER = 'DELETE FROM users 
                     WHERE id = :userId';
// roles
const GET_ROLES = 'SELECT * FROM roles';

const SET_ROLE_WRITER = 'INSERT INTO users_roles 
                         VALUES (:userId, :roleId)';

const UNBOUND_ROLE_FROM_USER = 'DELETE FROM users_roles 
                                WHERE role_id = :roleId';