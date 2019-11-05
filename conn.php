<?php
$user = getenv('USERNAME');
$pass = getenv('PASSWORD');

$dbServerName = "remotemysql.com";
$dbUserName = $user;
$dbPassword = $pass;
$dbName = $user;

$dsn = "mysql:host=$dbServerName;dbname=$dbName;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
try {
    $conn = new PDO($dsn, $dbUserName, $dbPassword, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int) $e->getCode());
}