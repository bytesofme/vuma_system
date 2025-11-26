<?php
// Render SQLite Configuration
$database_file = __DIR__ . '/vuma_parcel.db';

try {
    $pdo = new PDO("sqlite:" . $database_file);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Initialize database
    initDatabase($pdo);
    
} catch(PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

function initDatabase($pdo) {
    // Your existing database initialization code
    // (Same as the SQLite version I provided earlier)
}
?>
