<?php
// Database configuration
$servername = "localhost";
$username = "jos";
$password = "Boyfaded7552";
$dbname = "blog";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully\n";
} else {
    echo "Error creating database: " . $conn->error . "\n";
}

// Select the created database
$conn->select_db($dbname);

// Create users table
$sql = "CREATE TABLE IF NOT EXISTS users (
    user_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
if ($conn->query($sql) === TRUE) {
    echo "Table 'users' created successfully\n";
} else {
    echo "Error creating table: " . $conn->error . "\n";
}

// Create posts table
$sql = "CREATE TABLE IF NOT EXISTS posts (
    post_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    author_id INT(11),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES users(user_id) ON DELETE CASCADE
)";
if ($conn->query($sql) === TRUE) {
    echo "Table 'posts' created successfully\n";
} else {
    echo "Error creating table: " . $conn->error . "\n";
}

// Create comments table
$sql = "CREATE TABLE IF NOT EXISTS comments (
    comment_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    post_id INT(11),
    commenter_name VARCHAR(255) NOT NULL,
    commenter_email VARCHAR(255) NOT NULL,
    comment_text TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES posts(post_id) ON DELETE CASCADE
)";
if ($conn->query($sql) === TRUE) {
    echo "Table 'comments' created successfully\n";
} else {
    echo "Error creating table: " . $conn->error . "\n";
}

// Close connection
$conn->close();