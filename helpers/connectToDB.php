<?php

try {
    $pdo = new PDO(
      'mysql:host=localhost;dbname=php_and_mysql',
      'root',
      'root',
      [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);


} catch(PDOException $e) {
    echo "Невозможно установить соединение с базой данных<br>" . $e->getMessage();
}

function vardump($input)
{
    if(!$input){return false;}
    if(gettype($input)=="boolean")
    {
        echo var_dump($input);
    }
    else
    {
        echo "<pre>".print_r($input,true)."</pre>";
    }
}