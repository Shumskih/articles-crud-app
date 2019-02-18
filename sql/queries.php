<?php

// articles
const GET_ALL_PUBLISHED_ARTICLES = 'SELECT * FROM articles 
                                    WHERE published = 1 ORDER BY datetime DESC';

const GET_ARTICLE_AND_BOUND_USER = 'SELECT articles.id as articleId, title, body, datetime, published, users.id as userId FROM articles
                                    INNER JOIN users_articles on users_articles.article_id = articles.id
                                    INNER JOIN users on users_articles.user_id = users.id
                                    WHERE articles.id = :id';

const DELETE_ARTICLE = 'DELETE FROM articles 
                        WHERE id = :id';

const UNBOUND_ARTICLE_FROM_CATEGORY = 'DELETE from categories_articles 
                                       WHERE article_id = :id';

const UNBOUND_ARTICLE_FROM_USER = 'DELETE from users_articles 
                                   WHERE article_id = :id';

const INSERT_ARTICLE_PUBLISHED = 'INSERT INTO articles 
                                  VALUES (null, :title, :short_desc, :body, :img, now(), null, true, false, false, null)';

const INSERT_ARTICLE_UNPUBLISHED = 'INSERT INTO articles 
                                    VALUES (null, :title, :short_desc, :body, :img, now(), null, false, false, true, null)';

const BOUND_ARTICLE_TO_CATEGORY = 'INSERT INTO categories_articles 
                                   VALUES (:categoryId, :articleId)';

const BOUND_ARTICLE_TO_USER = 'INSERT INTO users_articles 
                               VALUES (:userId, :articleId)';

// categories
const GET_ALL_CATEGORIES = 'SELECT * FROM categories ORDER BY name';