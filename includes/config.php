<?php
// SQLite Database Configuration for Render
$database_file = __DIR__ . '/vuma_parcel.db';

// For Render free tier - use in-memory database as fallback
try {
    // First try file-based database
    if (!file_exists($database_file)) {
        touch($database_file);
    }
    
    $pdo = new PDO("sqlite:" . $database_file);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Test if tables exist
    $test = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name='users'");
    $tablesExist = $test->fetch();
    
    if (!$tablesExist) {
        initDatabase($pdo);
    }
    
} catch (PDOException $e) {
    // Fallback to in-memory database for demo
    $pdo = new PDO('sqlite::memory:');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    initDatabase($pdo);
}

function initDatabase($pdo) {
    // Drop tables if they exist
    $pdo->exec("DROP TABLE IF EXISTS users");
    $pdo->exec("DROP TABLE IF EXISTS lockers"); 
    $pdo->exec("DROP TABLE IF EXISTS parcels");
    
    // Users table
    $pdo->exec("CREATE TABLE users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        full_name VARCHAR(100) NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        phone VARCHAR(20),
        password VARCHAR(255) NOT NULL,
        role VARCHAR(10) DEFAULT 'customer',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");
    
    // Lockers table
    $pdo->exec("CREATE TABLE lockers (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        locker_number VARCHAR(10) UNIQUE NOT NULL,
        status VARCHAR(20) DEFAULT 'available',
        location VARCHAR(100)
    )");
    
    // Parcels table
    $pdo->exec("CREATE TABLE parcels (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        tracking_number VARCHAR(50) UNIQUE NOT NULL,
        sender_name VARCHAR(100) NOT NULL,
        recipient_email VARCHAR(100) NOT NULL,
        recipient_phone VARCHAR(20),
        locker_id INTEGER,
        status VARCHAR(20) DEFAULT 'in_transit',
        otp_code VARCHAR(4),
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");
    
    // Insert default admin
    $hashed_password = password_hash('admin123', PASSWORD_DEFAULT);
    $pdo->prepare("INSERT INTO users (full_name, email, password, role) VALUES (?, ?, ?, ?)")
        ->execute(['Admin User', 'admin@vuma.com', $hashed_password, 'admin']);
    
    // Insert sample lockers
    $lockers = [
        ['A01', 'Eldoret Main Station'],
        ['A02', 'Eldoret Main Station'], 
        ['A03', 'Eldoret Main Station'],
        ['B01', 'Eldoret Town Branch'],
        ['B02', 'Eldoret Town Branch']
    ];
    
    foreach ($lockers as $locker) {
        $pdo->prepare("INSERT INTO lockers (locker_number, location) VALUES (?, ?)")
            ->execute($locker);
    }
    
    // Insert sample parcel
    $pdo->prepare("INSERT INTO parcels (tracking_number, sender_name, recipient_email, status) VALUES (?, ?, ?, ?)")
        ->execute(['VUMA001', 'Amazon Kenya', 'admin@vuma.com', 'in_transit']);
}

// Helper functions
function emailExists($pdo, $email) {
    try {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetchColumn() > 0;
    } catch (PDOException $e) {
        return false;
    }
}

function getUserByEmail($pdo, $email) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return null;
    }
}
?>
