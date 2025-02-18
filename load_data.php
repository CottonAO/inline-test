<?php
$host = 'localhost';
$db   = 'inline_test';
$user = 'root'; // Замените на вашего пользователя БД
$pass = '';     // Замените на ваш пароль БД
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $pass, $opt);

// Загрузка записей
$posts = json_decode(file_get_contents('https://jsonplaceholder.typicode.com/posts'), true);
$postCount = 0;
foreach ($posts as $post) {
    $stmt = $pdo->prepare("INSERT INTO posts (id, userId, title, body) VALUES (?, ?, ?, ?)");
    $stmt->execute([$post['id'], $post['userId'], $post['title'], $post['body']]);
    $postCount++;
}

// Загрузка комментариев
$comments = json_decode(file_get_contents('https://jsonplaceholder.typicode.com/comments'), true);
$commentCount = 0;
foreach ($comments as $comment) {
    $stmt = $pdo->prepare("INSERT INTO comments (id, postId, name, email, body) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$comment['id'], $comment['postId'], $comment['name'], $comment['email'], $comment['body']]);
    $commentCount++;
}

echo "Загружено $postCount записей и $commentCount комментариев\n";