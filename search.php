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
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Результаты поиска</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }

        .results-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            width: 100%;
            margin-top: 20px;
        }

        h2 {
            font-size: 24px;
            color: #333333;
            margin-bottom: 20px;
        }

        .result-item {
            border-bottom: 1px solid #eeeeee;
            padding: 15px 0;
        }

        .result-item:last-child {
            border-bottom: none;
        }

        .result-title {
            font-size: 18px;
            color: #007bff;
            margin-bottom: 10px;
        }

        .result-comment {
            font-size: 14px;
            color: #555555;
            line-height: 1.6;
        }

        .no-results {
            font-size: 16px;
            color: #ff0000;
            text-align: center;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
            font-size: 16px;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <?php
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
            echo '<div class="results-container">';
            echo '<h2>Результаты поиска:</h2>';
            foreach ($results as $row) {
                echo '<div class="result-item">';
                echo '<div class="result-title">' . htmlspecialchars($row['title']) . '</div>';
                echo '<div class="result-comment">' . htmlspecialchars($row['body']) . '</div>';
                echo '</div>';
            }
            echo '</div>';
        } else {
            echo '<div class="results-container">';
            echo '<p class="no-results">Ничего не найдено.</p>';
            echo '</div>';
        }
    } else {
        echo '<div class="results-container">';
        echo '<p class="no-results">Введите минимум 3 символа для поиска.</p>';
        echo '</div>';
    }
    ?>
    <a href="search_form.html" class="back-link">Вернуться к поиску</a>
</body>
</html>