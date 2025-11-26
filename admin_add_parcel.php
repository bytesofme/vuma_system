<?php
session_start();
require_once 'includes/config.php';
require_once 'includes/session.php';
requireAdmin();

$user_name = $_SESSION['user_name'];

// Get available lockers
try {
    $stmt = $pdo->prepare("SELECT * FROM lockers WHERE status = 'available'");
    $stmt->execute();
    $available_lockers = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $available_lockers = [];
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tracking_number = trim($_POST['tracking_number']);
    $sender_name = trim($_POST['sender_name']);
    $recipient_email = trim($_POST['recipient_email']);
    $recipient_phone = trim($_POST['recipient_phone']);
    $locker_id = $_POST['locker_id'];
    $status = $_POST['status'];

    if (empty($tracking_number) || empty($sender_name) || empty($recipient_email)) {
        $error = "Please fill in all required fields";
    } else {
        try {
            // Check if tracking number already exists
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM parcels WHERE tracking_number = ?");
            $stmt->execute([$tracking_number]);
            
            if ($stmt->fetchColumn() > 0) {
                $error = "Tracking number already exists";
            } else {
                // Insert new parcel
                $stmt = $pdo->prepare("INSERT INTO parcels (tracking_number, sender_name, recipient_email, recipient_phone, locker_id, status) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$tracking_number, $sender_name, $recipient_email, $recipient_phone, $locker_id, $status]);
                
                // Update locker status if locker is assigned
                if (!empty($locker_id)) {
                    $stmt = $pdo->prepare("UPDATE lockers SET status = 'occupied' WHERE id = ?");
                    $stmt->execute([$locker_id]);
                }
                
                $success = "Parcel added successfully!";
                
                // Clear form fields
                $tracking_number = $sender_name = $recipient_email = $recipient_phone = '';
                $locker_id = $status = '';
            }
            
        } catch (PDOException $e) {
            $error = "Database error: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Parcel - Admin Panel</title>
    <link rel="stylesheet" href="/css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .admin-container {
            max-width: 800px;
            margin: 80px auto 2rem;
            padding: 0 2rem;
        }
        
        .page-header {
            background: rgba(255, 255, 255, 0.95);
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
            backdrop-filter: blur(10px);
        }
        
        .form-container {
            background: white;
            padding: 3rem;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .form-group {
            margin-bottom: 2rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.8rem;
            color: #333;
            font-weight: 600;
            font-size: 1rem;
        }
        
        .form-control {
            width: 100%;
            padding: 1rem;
            border: 2px solid #e8f4f1;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #006b54;
            box-shadow: 0 0 0 3px rgba(0,107,84,0.1);
        }
        
        .submit-btn {
            width: 100%;
            padding: 1.2rem;
            background: linear-gradient(135deg, #006b54, #00a884);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .submit-btn:hover {
            background: linear-gradient(135deg, #005a46, #008f70);
            transform: translateY(-2px);
        }
        
        .alert {
            padding: 1.5rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
        }
        
        .alert-success {
            background: #e8f8ef;
            color: #00b894;
            border: 1px solid #00b894;
        }
        
        .alert-error {
            background: #ffeaea;
            color: #d63031;
            border: 1px solid #ff7675;
        }
        
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: #006b54;
            text-decoration: none;
            margin-bottom: 1.5rem;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <div class="logo">
                <i class="fas fa-box-open"></i>
                <span>VUMA LOCKERS - ADMIN</span>
            </div>
            <div class="nav-links">
                <a href="admin_dashboard.php" style="color: white;">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a>
                <span style="color: white;">Admin: <?php echo $user_name; ?></span>
                <a href="includes/logout.php" class="login-btn">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
    </nav>

    <div class="admin-container">
        <div class="page-header">
            <h1>📦 Add New Parcel</h1>
            <p>Register a new parcel for delivery to locker system</p>
        </div>
        
        <?php if (isset($success)): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> <?php echo $success; ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
        <div class="form-container">
            <form method="POST" action="">
                <div class="form-group">
                    <label for="tracking_number">Tracking Number *</label>
                    <input type="text" id="tracking_number" name="tracking_number" class="form-control" 
                           value="<?php echo isset($tracking_number) ? htmlspecialchars($tracking_number) : ''; ?>" 
                           placeholder="e.g., VUMA002" required>
                </div>
                
                <div class="form-group">
                    <label for="sender_name">Sender Name *</label>
                    <input type="text" id="sender_name" name="sender_name" class="form-control" 
                           value="<?php echo isset($sender_name) ? htmlspecialchars($sender_name) : ''; ?>" 
                           placeholder="e.g., Amazon Kenya" required>
                </div>
                
                <div class="form-group">
                    <label for="recipient_email">Recipient Email *</label>
                    <input type="email" id="recipient_email" name="recipient_email" class="form-control" 
                           value="<?php echo isset($recipient_email) ? htmlspecialchars($recipient_email) : ''; ?>" 
                           placeholder="e.g., user@example.com" required>
                </div>
                
                <div class="form-group">
                    <label for="recipient_phone">Recipient Phone (Optional)</label>
                    <input type="text" id="recipient_phone" name="recipient_phone" class="form-control" 
                           value="<?php echo isset($recipient_phone) ? htmlspecialchars($recipient_phone) : ''; ?>" 
                           placeholder="e.g., 0712345678">
                </div>
                
                <div class="form-group">
                    <label for="locker_id">Assign Locker (Optional)</label>
                    <select id="locker_id" name="locker_id" class="form-control">
                        <option value="">-- Select Locker --</option>
                        <?php foreach ($available_lockers as $locker): ?>
                            <option value="<?php echo $locker['id']; ?>">
                                Locker <?php echo $locker['locker_number']; ?> - <?php echo $locker['location']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="status">Parcel Status</label>
                    <select id="status" name="status" class="form-control">
                        <option value="in_transit">In Transit</option>
                        <option value="delivered">Delivered</option>
                    </select>
                </div>
                
                <button type="submit" class="submit-btn">
                    <i class="fas fa-plus"></i> Add Parcel
                </button>
            </form>
        </div>
    </div>
</body>
</html>
