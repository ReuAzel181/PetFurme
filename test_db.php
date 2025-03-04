<?php
$host = env('PROD_DB_HOST', '127.0.0.1');
$db   = env('PROD_DB_DATABASE', 'u211529883_pet_management');
$user = env('PROD_DB_USERNAME', 'u211529883_petfurme');
$pass = env('PROD_DB_PASSWORD', 'petfurMe234');
$charset = 'utf8mb4';

try {
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $pdo = new PDO($dsn, $user, $pass);
    echo "Connected successfully to database!";
    
    // Test query
    $stmt = $pdo->query('SHOW TABLES');
    echo "\nTables in database:\n";
    while ($row = $stmt->fetch()) {
        echo $row[0] . "\n";
    }
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
} 