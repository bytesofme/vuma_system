[file name]: includes/config.php
[file content begin]
<?php
// SQLite Database Configuration
$database_file = __DIR__ . '/vuma_parcel.db';

// Check if database file exists and is writable
if (!file_exists($database_file)) {
    // Create new database file
    touch($database_file);
    chmod($database_file, 0666);
}

try {
    $pdo = new PDO("sqlite:" . $database_file);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
    // Always check and create tables
    initDatabase($pdo);
    
} catch(PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

function initDatabase($pdo) {
    // Create users table if not exists
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        full_name VARCHAR(100) NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        phone VARCHAR(20),
        password VARCHAR(255) NOT NULL,
        role VARCHAR(10) DEFAULT 'customer',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");
    
    // Create lockers table if not exists
    $pdo->exec("CREATE TABLE IF NOT EXISTS lockers (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        locker_number VARCHAR(10) UNIQUE NOT NULL,
        status VARCHAR(20) DEFAULT 'available',
        location VARCHAR(100)
    )");
    
    // Create parcels table if not exists
    $pdo->exec("CREATE TABLE IF NOT EXISTS parcels (
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
    
    // Check if admin user exists
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = 'admin@vuma.com'");
    $stmt->execute();
    if ($stmt->fetchColumn() == 0) {
        // Insert default admin
        $hashed_password = password_hash('admin123', PASSWORD_DEFAULT);
        $pdo->prepare("INSERT INTO users (full_name, email, password, role) VALUES (?, ?, ?, ?)")
            ->execute(['Admin User', 'admin@vuma.com', $hashed_password, 'admin']);
    }
    
    // Check if lockers exist
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM lockers");
    $stmt->execute();
    if ($stmt->fetchColumn() == 0) {
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
    }
    
    // Check if sample parcel exists
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM parcels WHERE tracking_number = 'VUMA001'");
    $stmt->execute();
    if ($stmt->fetchColumn() == 0) {
        // Insert sample parcel for demo
        $pdo->prepare("INSERT INTO parcels (tracking_number, sender_name, recipient_email, status) VALUES (?, ?, ?, ?)")
            ->execute(['VUMA001', 'Amazon Kenya', 'admin@vuma.com', 'in_transit']);
    }
}

// Function to check if email exists (for signup)
function emailExists($pdo, $email) {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
    $stmt->execute([$email]);
    return $stmt->fetchColumn() > 0;
}

// Function to get user by email (for login)
function getUserByEmail($pdo, $email) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
[file content end]
