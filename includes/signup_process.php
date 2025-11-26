<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($full_name) || empty($email) || empty($phone) || empty($password)) {
        header('Location: ../signup.php?error=All fields are required');
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: ../signup.php?error=Invalid email format');
        exit();
    }

    if ($password !== $confirm_password) {
        header('Location: ../signup.php?error=Passwords do not match');
        exit();
    }

    if (strlen($password) < 6) {
        header('Location: ../signup.php?error=Password must be at least 6 characters');
        exit();
    }

    try {
        // Check if email exists using the function from config.php
        if (emailExists($pdo, $email)) {
            header('Location: ../signup.php?error=Email already registered');
            exit();
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $pdo->prepare("INSERT INTO users (full_name, email, phone, password, role) VALUES (?, ?, ?, ?, 'customer')");
        $stmt->execute([$full_name, $email, $phone, $hashed_password]);

        header('Location: ../login.php?success=Account created successfully! Please login');
        exit();

    } catch (PDOException $e) {
        // If it's a unique constraint violation, email already exists
        if (strpos($e->getMessage(), 'UNIQUE constraint failed') !== false) {
            header('Location: ../signup.php?error=Email already registered');
        } else {
            header('Location: ../signup.php?error=Database error: ' . $e->getMessage());
        }
        exit();
    }
} else {
    header('Location: ../signup.php');
    exit();
}
?>
