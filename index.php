<?php
session_start();

// Redirect to dashboard if already logged in
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
        /* MAGNIFICENT HOMEPAGE STYLES */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        :root {
            --primary: #006b54;
            --primary-dark: #005a46;
            --secondary: #d31621;
            --secondary-dark: #b3121a;
            --accent: #00a884;
            --light: #f8f9fa;
            --dark: #333;
            --white: #ffffff;
            --gradient: linear-gradient(135deg, var(--primary), var(--accent));
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: var(--dark);
            overflow-x: hidden;
            background: var(--light);
        }
        
        /* Animated Background */
        .animated-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -2;
            background: 
                radial-gradient(circle at 20% 80%, rgba(0, 107, 84, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(211, 22, 33, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(0, 168, 132, 0.05) 0%, transparent 50%);
            animation: float 20s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            33% { transform: translateY(-20px) rotate(1deg); }
            66% { transform: translateY(10px) rotate(-1deg); }
        }
        
        /* Navigation - Glass Morphism */
        .navbar {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            padding: 1.2rem 0;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }
        
        .navbar.scrolled {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(30px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        
        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--white);
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .navbar.scrolled .logo {
            color: var(--primary);
        }
        
        .logo i {
            font-size: 2.2rem;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }
        
        .nav-links a {
            color: var(--white);
            text-decoration: none;
            padding: 0.8rem 1.5rem;
            border-radius: 50px;
            transition: all 0.3s ease;
            font-weight: 600;
            position: relative;
            overflow: hidden;
        }
        
        .navbar.scrolled .nav-links a {
            color: var(--dark);
        }
        
        .nav-links a::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: var(--gradient);
            transition: left 0.3s ease;
            z-index: -1;
            border-radius: 50px;
        }
        
        .nav-links a:hover::before {
            left: 0;
        }
        
        .nav-links a:hover {
            color: var(--white);
            transform: translateY(-2px);
        }
        
        .login-btn, .signup-btn {
            background: var(--secondary);
            color: var(--white);
            padding: 0.8rem 2rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 700;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        
        .login-btn:hover, .signup-btn:hover {
            background: var(--secondary-dark);
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(211, 22, 33, 0.3);
        }
        
        /* Hero Section - Spectacular */
        .hero-section {
            background: var(--gradient);
            color: var(--white);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="80" cy="40" r="1.5" fill="rgba(255,255,255,0.1)"/><circle cx="40" cy="80" r="1" fill="rgba(255,255,255,0.1)"/></svg>') repeat,
                linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.1) 50%, transparent 70%);
            animation: sparkle 3s ease-in-out infinite;
        }
        
        @keyframes sparkle {
            0%, 100% { opacity: 0.3; }
            50% { opacity: 0.6; }
        }
        
        .hero-overlay {
            width: 100%;
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
            text-align: center;
            position: relative;
            z-index: 2;
        }
        
        .hero-content h1 {
            font-size: 4.5rem;
            margin-bottom: 1.5rem;
            font-weight: 800;
            line-height: 1.1;
            background: linear-gradient(135deg, var(--white), #f0f0f0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: glow 2s ease-in-out infinite alternate;
        }
        
        @keyframes glow {
            from { text-shadow: 0 0 20px rgba(255,255,255,0.5); }
            to { text-shadow: 0 0 30px rgba(255,255,255,0.8); }
        }
        
        .hero-subtitle {
            font-size: 1.4rem;
            margin-bottom: 3rem;
            opacity: 0.9;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.6;
            font-weight: 300;
        }
        
        .hero-buttons {
            display: flex;
            gap: 1.5rem;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .cta-button {
            padding: 1.3rem 3rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 700;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.8rem;
            font-size: 1.1rem;
            position: relative;
            overflow: hidden;
        }
        
        .cta-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            transition: left 0.6s;
        }
        
        .cta-button:hover::before {
            left: 100%;
        }
        
        .cta-button.primary {
            background: var(--secondary);
            color: var(--white);
            box-shadow: 0 10px 30px rgba(211, 22, 33, 0.3);
        }
        
        .cta-button.secondary {
            background: transparent;
            color: var(--white);
            border: 2px solid var(--white);
        }
        
        .cta-button:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.2);
        }
        
        .cta-button.primary:hover {
            background: var(--secondary-dark);
            box-shadow: 0 15px 40px rgba(211, 22, 33, 0.4);
        }
        
        .cta-button.secondary:hover {
            background: var(--white);
            color: var(--primary);
        }
        
        /* Features Section */
        .features-section {
            padding: 8rem 2rem;
            background: var(--white);
            position: relative;
        }
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
        }
        
        .section-header {
            text-align: center;
            margin-bottom: 4rem;
        }
        
        .section-header h2 {
            font-size: 3.5rem;
            margin-bottom: 1rem;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 800;
        }
        
        .section-header p {
            font-size: 1.3rem;
            color: #666;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 3rem;
            margin-top: 4rem;
        }
        
        .feature-card {
            background: var(--white);
            padding: 3rem 2rem;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 15px 40px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            border: 1px solid rgba(0,0,0,0.05);
            position: relative;
            overflow: hidden;
        }
        
        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient);
        }
        
        .feature-card:hover {
            transform: translateY(-15px);
            box-shadow: 0 25px 60px rgba(0,0,0,0.15);
        }
        
        .feature-card i {
            font-size: 4rem;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1.5rem;
            display: block;
        }
        
        .feature-card h3 {
            font-size: 1.6rem;
            margin-bottom: 1rem;
            color: var(--dark);
            font-weight: 700;
        }
        
        .feature-card p {
            color: #666;
            line-height: 1.7;
            font-size: 1.1rem;
        }
        
        /* How It Works Section */
        .how-it-works {
            padding: 8rem 2rem;
            background: var(--light);
            position: relative;
        }
        
        .steps-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 3rem;
            margin-top: 4rem;
        }
        
        .step {
            text-align: center;
            padding: 3rem 2rem;
            background: var(--white);
            border-radius: 20px;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            position: relative;
        }
        
        .step:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 50px rgba(0,0,0,0.15);
        }
        
        .step-number {
            background: var(--gradient);
            color: var(--white);
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: bold;
            margin: 0 auto 2rem;
            box-shadow: 0 10px 25px rgba(0,107,84,0.3);
            position: relative;
        }
        
        .step-number::after {
            content: '';
            position: absolute;
            top: -5px;
            left: -5px;
            right: -5px;
            bottom: -5px;
            border: 2px solid var(--primary);
            border-radius: 50%;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.1); opacity: 0.7; }
        }
        
        .step h3 {
            font-size: 1.6rem;
            margin-bottom: 1rem;
            color: var(--primary);
            font-weight: 700;
        }
        
        .step p {
            color: #666;
            line-height: 1.7;
            font-size: 1.1rem;
        }
        
        /* Footer */
        .footer {
            background: var(--dark);
            color: var(--white);
            text-align: center;
            padding: 4rem 2rem;
            position: relative;
        }
        
        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--gradient);
        }
        
        .footer p {
            margin: 0;
            font-size: 1.1rem;
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
                font-size: 2.8rem;
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
                justify-content: center;
            }
            
            .section-header h2 {
                font-size: 2.5rem;
            }
            
            .features-grid, .steps-grid {
                grid-template-columns: 1fr;
            }
        }
        
        /* Floating Animation */
        .floating {
            animation: floating 3s ease-in-out infinite;
        }
        
        @keyframes floating {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
    </style>
</head>
<body>
    <!-- Animated Background -->
    <div class="animated-bg"></div>
    
    <!-- Navigation -->
    <nav class="navbar" id="navbar">
        <div class="nav-container">
            <a href="#" class="logo">
                <i class="fas fa-box-open floating"></i>
                <span>VUMA LOCKERS</span>
            </a>
            <div class="nav-links">
                <a href="#features">Features</a>
                <a href="#how-it-works">How It Works</a>
                <a href="login.php" class="login-btn">Login</a>
                <a href="signup.php" class="signup-btn">Sign Up</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-overlay">
            <div class="hero-content">
                <h1>Smart Parcel Management</h1>
                <p class="hero-subtitle">Revolutionizing package delivery in Eldoret with secure, automated smart lockers. Experience 24/7 convenience with military-grade security and instant notifications.</p>
                <div class="hero-buttons">
                    <a href="signup.php" class="cta-button primary">
                        <i class="fas fa-rocket"></i>
                        Get Started Free
                    </a>
                    <a href="#features" class="cta-button secondary">
                        <i class="fas fa-play-circle"></i>
                        Watch Demo
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="features-section">
        <div class="container">
            <div class="section-header">
                <h2>Why Choose Vuma Lockers?</h2>
                <p>Experience the future of parcel delivery with cutting-edge technology and unparalleled convenience</p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <i class="fas fa-shield-alt"></i>
                    <h3>Military-Grade Security</h3>
                    <p>One-time passwords with encryption ensure only authorized access. Advanced surveillance and tamper-proof lockers protect your packages 24/7.</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-bolt"></i>
                    <h3>Instant Real-Time Alerts</h3>
                    <p>Receive immediate notifications via SMS and email. Track your package from delivery to pickup with live status updates and estimated times.</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-clock"></i>
                    <h3>24/7 Unlimited Access</h3>
                    <p>No more missed deliveries. Collect your parcels anytime - day or night, weekends or holidays. Your schedule, your convenience.</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-map-marked-alt"></i>
                    <h3>Strategic Locations</h3>
                    <p>Multiple conveniently located stations across Eldoret. Easy access from residential areas, shopping centers, and business districts.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="how-it-works">
        <div class="container">
            <div class="section-header">
                <h2>How It Works</h2>
                <p>Simple, secure, and efficient - your package delivery revolutionized in three easy steps</p>
            </div>
            <div class="steps-grid">
                <div class="step">
                    <div class="step-number">1</div>
                    <h3>Smart Delivery</h3>
                    <p>Your package is securely stored in our climate-controlled smart lockers. Advanced sensors monitor temperature and humidity for sensitive items.</p>
                </div>
                <div class="step">
                    <div class="step-number">2</div>
                    <h3>Secure OTP Generation</h3>
                    <p>Receive a unique 6-digit security code delivered instantly to your registered contact methods. Codes expire after use for maximum security.</p>
                </div>
                <div class="step">
                    <div class="step-number">3</div>
                    <h3>Convenient Collection</h3>
                    <p>Visit any locker station, enter your secure code, and retrieve your package. Touch-free operation with automated door systems.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2025 Vuma Parcel Lockers. Transforming Delivery in Eldoret. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 100) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Add loading animation
        window.addEventListener('load', function() {
            document.body.style.opacity = '0';
            document.body.style.transition = 'opacity 0.5s ease';
            setTimeout(() => {
                document.body.style.opacity = '1';
            }, 100);
        });
    </script>
</body>
</html>
