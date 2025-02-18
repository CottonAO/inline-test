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

$query = $_GET['query'] ?? '';
if (strlen($query) >= 3) {
    $stmt = $pdo->prepare("
        SELECT p.title, c.body 
        FROM comments c 
        JOIN posts p ON c.postId = p.id 
        WHERE c.body LIKE :query
    ");
    $stmt->execute(['query' => "%$query%"]);
    $results = $stmt->fetchAll();

    if (count($results) > 0) {
        echo "<h2>Результаты поиска:</h2>";
        foreach ($results as $row) {
            echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
            echo "<p>" . htmlspecialchars($row['body']) . "</p>";
        }
    } else {
        echo "<p>Ничего не найдено.</p>";
    }
} else {
    echo "<p>Введите минимум 3 символа для поиска.</p>";
}