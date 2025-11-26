<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vuma Parcel Lockers - Smart Package Management</title>
    <link rel="stylesheet" href="/css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Emergency Homepage Styles */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
        }
        
        .hero-section {
            background: linear-gradient(135deg, #006b54, #00a884);
            color: white;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        
        .hero-overlay {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        .navbar {
            background: transparent;
            padding: 1rem 0;
            margin-bottom: 2rem;
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
            font-size: 1.8rem;
            font-weight: bold;
            color: white;
        }
        
        .logo i {
            font-size: 2rem;
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
            border-radius: 8px;
            transition: all 0.3s;
            font-weight: 600;
        }
        
        .nav-links a:hover {
            background: rgba(255,255,255,0.15);
            transform: translateY(-2px);
        }
        
        .login-btn, .signup-btn {
            background: #d31621;
            color: white;
            padding: 0.8rem 1.8rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s;
        }
        
        .login-btn:hover, .signup-btn:hover {
            background: #b3121a;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(211, 22, 33, 0.4);
        }
        
        .hero-content {
            text-align: center;
            max-width: 800px;
            margin: 0 auto;
        }
        
        .hero-content h1 {
            font-size: 4rem;
            margin-bottom: 1.5rem;
            font-weight: 800;
            line-height: 1.2;
        }
        
        .hero-subtitle {
            font-size: 1.4rem;
            margin-bottom: 3rem;
            opacity: 0.9;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.6;
        }
        
        .hero-buttons {
            display: flex;
            gap: 1.5rem;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .cta-button {
            padding: 1.2rem 2.5rem;
            border-radius: 12px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s;
            display: inline-block;
            font-size: 1.1rem;
        }
        
        .cta-button.primary {
            background: #d31621;
            color: white;
            box-shadow: 0 5px 15px rgba(211, 22, 33, 0.3);
        }
        
        .cta-button.secondary {
            background: transparent;
            color: white;
            border: 2px solid white;
        }
        
        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        }
        
        .cta-button.primary:hover {
            background: #b3121a;
            box-shadow: 0 8px 25px rgba(211, 22, 33, 0.4);
        }
        
        .cta-button.secondary:hover {
            background: white;
            color: #006b54;
        }
        
        .features-section {
            padding: 6rem 2rem;
            background: #f8f9fa;
        }
        
        .how-it-works {
            padding: 6rem 2rem;
            background: white;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .container h2 {
            text-align: center;
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #006b54;
            font-weight: 700;
        }
        
        .container > p {
            text-align: center;
            font-size: 1.2rem;
            color: #666;
            margin-bottom: 3rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2.5rem;
            margin-top: 4rem;
        }
        
        .feature-card {
            background: white;
            padding: 3rem 2rem;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.3s;
            border-top: 4px solid #006b54;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
        
        .feature-card i {
            font-size: 3.5rem;
            color: #006b54;
            margin-bottom: 1.5rem;
        }
        
        .feature-card h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: #333;
        }
        
        .feature-card p {
            color: #666;
            line-height: 1.6;
        }
        
        .steps-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 3rem;
            margin-top: 4rem;
        }
        
        .step {
            text-align: center;
            padding: 2.5rem;
            background: #f8f9fa;
            border-radius: 15px;
            transition: all 0.3s;
        }
        
        .step:hover {
            background: white;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transform: translateY(-5px);
        }
        
        .step-number {
            background: linear-gradient(135deg, #006b54, #00a884);
            color: white;
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            font-weight: bold;
            margin: 0 auto 1.5rem;
            box-shadow: 0 5px 15px rgba(0,107,84,0.3);
        }
        
        .step h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: #006b54;
        }
        
        .step p {
            color: #666;
            line-height: 1.6;
        }
        
        .footer {
            background: #333;
            color: white;
            text-align: center;
            padding: 3rem 2rem;
        }
        
        .footer p {
            margin: 0;
            font-size: 1rem;
            opacity: 0.8;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .nav-container {
                flex-direction: column;
                gap: 1rem;
            }
            
            .nav-links {
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .hero-content h1 {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.1rem;
            }
            
            .hero-buttons {
                flex-direction: column;
                align-items: center;
            }
            
            .cta-button {
                width: 100%;
                max-width: 300px;
                text-align: center;
            }
            
            .container h2 {
                font-size: 2.2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Hero Section with Background -->
    <div class="hero-section">
        <div class="hero-overlay">
            <nav class="navbar">
                <div class="nav-container">
                    <div class="logo">
                        <i class="fas fa-box-open"></i>
                        <span>VUMA LOCKERS</span>
                    </div>
                    <div class="nav-links">
                        <a href="#features">Features</a>
                        <a href="#about">How It Works</a>
                        <a href="login.php" class="login-btn">Login</a>
                        <a href="signup.php" class="signup-btn">Sign Up</a>
                    </div>
                </div>
            </nav>

            <div class="hero-content">
                <h1>Smart Parcel Management</h1>
                <p class="hero-subtitle">Secure, convenient, and automated package delivery with 24/7 access to smart lockers in Eldoret</p>
                <div class="hero-buttons">
                    <a href="signup.php" class="cta-button primary">Get Started</a>
                    <a href="#features" class="cta-button secondary">Learn More</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <section id="features" class="features-section">
        <div class="container">
            <h2>Why Choose Vuma Lockers?</h2>
            <p>Experience the future of parcel delivery with our secure and convenient locker system</p>
            <div class="features-grid">
                <div class="feature-card">
                    <i class="fas fa-shield-alt"></i>
                    <h3>Secure Access</h3>
                    <p>One-time passwords ensure only you can access your packages with maximum security</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-bell"></i>
                    <h3>Instant Notifications</h3>
                    <p>Get real-time updates and alerts when your package arrives at the locker</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-clock"></i>
                    <h3>24/7 Availability</h3>
                    <p>Pick up your parcels anytime day or night that suits your schedule</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-map-marker-alt"></i>
                    <h3>Convenient Locations</h3>
                    <p>Multiple locker stations strategically located across Eldoret for easy access</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="about" class="how-it-works">
        <div class="container">
            <h2>How It Works</h2>
            <p>Simple three-step process to get your packages securely</p>
            <div class="steps-grid">
                <div class="step">
                    <div class="step-number">1</div>
                    <h3>Package Arrival</h3>
                    <p>Your package is securely stored in one of our temperature-controlled smart lockers upon delivery</p>
                </div>
                <div class="step">
                    <div class="step-number">2</div>
                    <h3>Receive OTP</h3>
                    <p>Get a unique 4-digit security code sent directly to your registered email and phone number</p>
                </div>
                <div class="step">
                    <div class="step-number">3</div>
                    <h3>Collect Package</h3>
                    <p>Visit the locker station, enter your code, and retrieve your package at your convenience</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <p>&copy; 2025 Vuma Parcel Lockers. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
