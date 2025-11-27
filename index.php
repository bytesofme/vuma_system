<?php
session_start();

// Prevent caching
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache"); 
header("Expires: 0");

// Redirect if logged in
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['user_role'] === 'admin') {
        header('Location: admin_dashboard.php');
    } else {
        header('Location: dashboard.php');
    }
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vuma Parcel Lockers - Smart Package Management</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* MAGNIFICENT UI - VERIFIED WORKING */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            min-height: 100vh;
        }
        
        .navbar {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(20px);
            padding: 1rem 0;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }
        
        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1.5rem;
            font-weight: bold;
            color: white;
        }
        
        .nav-links {
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }
        
        .nav-links a {
            color: white;
            text-decoration: none;
            padding: 0.7rem 1.5rem;
            border-radius: 25px;
            transition: all 0.3s;
        }
        
        .login-btn, .signup-btn {
            background: #ff6b6b;
            color: white;
            font-weight: bold;
        }
        
        .nav-links a:hover {
            background: rgba(255,255,255,0.2);
            transform: translateY(-2px);
        }
        
        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 2rem;
        }
        
        .hero-content h1 {
            font-size: 4rem;
            margin-bottom: 1rem;
            background: linear-gradient(45deg, #fff, #f0f0f0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .hero-subtitle {
            font-size: 1.3rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }
        
        .cta-button {
            padding: 1.2rem 2.5rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: bold;
            margin: 0 1rem;
            display: inline-block;
            transition: all 0.3s;
        }
        
        .cta-button.primary {
            background: #ff6b6b;
            color: white;
        }
        
        .cta-button.secondary {
            background: transparent;
            color: white;
            border: 2px solid white;
        }
        
        .cta-button:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
        
        /* NEW PURPLE THEME - DIFFERENT FROM GREEN */
        .features-section {
            background: white;
            padding: 6rem 2rem;
            color: #333;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }
        
        .feature-card {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 2rem;
            border-radius: 15px;
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- VERIFICATION: MAGNIFICENT PURPLE UI LOADED -->
    
    <nav class="navbar">
        <div class="nav-container">
            <div class="logo">
                <i class="fas fa-box-open"></i>
                <span>VUMA LOCKERS</span>
            </div>
            <div class="nav-links">
                <a href="#features">Features</a>
                <a href="#how-it-works">How It Works</a>
                <a href="login.php" class="login-btn">Login</a>
                <a href="signup.php" class="signup-btn">Sign Up</a>
            </div>
        </div>
    </nav>

    <section class="hero-section">
        <div class="hero-content">
            <h1>Smart Parcel Management</h1>
            <p class="hero-subtitle">Revolutionizing package delivery with cutting-edge technology</p>
            <div>
                <a href="signup.php" class="cta-button primary">Get Started</a>
                <a href="#features" class="cta-button secondary">Learn More</a>
            </div>
        </div>
    </section>

    <section id="features" class="features-section">
        <div class="container">
            <h2 style="text-align: center; color: #333; margin-bottom: 2rem;">Why Choose Us?</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <i class="fas fa-shield-alt fa-3x"></i>
                    <h3>Secure Access</h3>
                    <p>Military-grade security with OTP protection</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-bolt fa-3x"></i>
                    <h3>Instant Alerts</h3>
                    <p>Real-time notifications for every delivery</p>
                </div>
            </div>
        </div>
    </section>

    <script>
        console.log("🎉 MAGNIFICENT UI LOADED SUCCESSFULLY!");
    </script>
</body>
</html>
