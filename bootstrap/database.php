<?php

$container['pdo'] = function ($c) {
    $driver = $c->settings['db']['driver'];
    $host = $c->settings['db']['host'];
    $dbname = $c->settings['db']['database'];
    $username = $c->settings['db']['username'];
    $password = $c->settings['db']['password'];
    $charset = $c->settings['db']['charset'];
    $collate = $c->settings['db']['collation'];
    $dsn = "$driver:host=$host;dbname=$dbname";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_PERSISTENT => false,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES $charset COLLATE $collate"
    ];
    return new PDO($dsn, $username, $password, $options);
};