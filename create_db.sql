CREATE DATABASE IF NOT EXISTS inline_test;
USE inline_test;

CREATE TABLE IF NOT EXISTS posts (
    id INT PRIMARY KEY,
    userId INT,
    title VARCHAR(255),
    body TEXT
);

CREATE TABLE IF NOT EXISTS comments (
    id INT PRIMARY KEY,
    postId INT,
    name VARCHAR(255),
    email VARCHAR(255),
    body TEXT,
    FOREIGN KEY (postId) REFERENCES posts(id)
);