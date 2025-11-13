<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JobTracker - Streamline Your Job Application Process</title>
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.min.css') }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            overflow-x: hidden;
            padding-top: 80px;
        }
        
        /* Navbar */
        .landing-navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .landing-navbar.scrolled {
            background: rgba(255, 255, 255, 0.98);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.15);
        }
        
        .navbar-brand-text {
            font-size: 1.5rem;
            font-weight: 900;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .nav-link-custom {
            color: #2d3748;
            font-weight: 600;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .nav-link-custom::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 2px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            transition: width 0.3s ease;
        }
        
        .nav-link-custom:hover {
            color: #667eea;
        }
        
        .nav-link-custom:hover::after {
            width: 80%;
        }
        
        .btn-nav {
            padding: 0.5rem 1.5rem;
            border-radius: 50px;
            font-weight: 700;
            transition: all 0.3s ease;
            border: none;
        }
        
        .btn-nav.login {
            color: #667eea;
            background: transparent;
            border: 2px solid #667eea;
        }
        
        .btn-nav.login:hover {
            background: #667eea;
            color: white;
        }
        
        .btn-nav.signup {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }
        
        .btn-nav.signup:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }
        
        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 800px;
            height: 800px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
        }
        
        .hero-section::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -10%;
            width: 600px;
            height: 600px;
            background: rgba(255,255,255,0.08);
            border-radius: 50%;
        }
        
        .hero-content {
            position: relative;
            z-index: 1;
            color: white;
            padding: 4rem 0;
        }
        
        .hero-title {
            font-size: 4rem;
            font-weight: 900;
            line-height: 1.2;
            margin-bottom: 1.5rem;
        }
        
        .hero-subtitle {
            font-size: 1.5rem;
            opacity: 0.95;
            margin-bottom: 2.5rem;
            font-weight: 400;
        }
        
        .cta-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }
        
        .btn-hero {
            padding: 1rem 2.5rem;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .btn-hero.primary {
            background: white;
            color: #667eea;
        }
        
        .btn-hero.primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(255,255,255,0.3);
            color: #667eea;
        }
        
        .btn-hero.secondary {
            background: rgba(255,255,255,0.2);
            color: white;
            border: 2px solid white;
        }
        
        .btn-hero.secondary:hover {
            background: rgba(255,255,255,0.3);
            transform: translateY(-3px);
            color: white;
        }
        
        /* Features Section */
        .features-section {
            padding: 6rem 0;
            background: #f8f9ff;
        }
        
        .section-title {
            text-align: center;
            font-size: 3rem;
            font-weight: 800;
            color: #2d3748;
            margin-bottom: 1rem;
        }
        
        .section-subtitle {
            text-align: center;
            font-size: 1.2rem;
            color: #8b92a7;
            margin-bottom: 4rem;
        }
        
        .feature-card {
            background: white;
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 60px rgba(0,0,0,0.12);
        }
        
        .feature-icon {
            width: 70px;
            height: 70px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin-bottom: 1.5rem;
        }
        
        .feature-card:nth-child(1) .feature-icon {
            background: linear-gradient(135deg, #667eea, #764ba2);
        }
        
        .feature-card:nth-child(2) .feature-icon {
            background: linear-gradient(135deg, #f093fb, #f5576c);
        }
        
        .feature-card:nth-child(3) .feature-icon {
            background: linear-gradient(135deg, #4facfe, #00f2fe);
        }
        
        .feature-card:nth-child(4) .feature-icon {
            background: linear-gradient(135deg, #43e97b, #38f9d7);
        }
        
        .feature-card:nth-child(5) .feature-icon {
            background: linear-gradient(135deg, #fa709a, #fee140);
        }
        
        .feature-card:nth-child(6) .feature-icon {
            background: linear-gradient(135deg, #30cfd0, #330867);
        }
        
        .feature-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 1rem;
        }
        
        .feature-description {
            color: #8b92a7;
            line-height: 1.7;
        }
        
        /* Stats Section */
        .stats-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 5rem 0;
            color: white;
        }
        
        .stat-item {
            text-align: center;
        }
        
        .stat-number {
            font-size: 3.5rem;
            font-weight: 900;
            margin-bottom: 0.5rem;
        }
        
        .stat-label {
            font-size: 1.2rem;
            opacity: 0.9;
        }
        
        /* CTA Section */
        .cta-section {
            padding: 6rem 0;
            text-align: center;
            background: white;
        }
        
        .cta-title {
            font-size: 3rem;
            font-weight: 800;
            color: #2d3748;
            margin-bottom: 1.5rem;
        }
        
        .cta-text {
            font-size: 1.3rem;
            color: #8b92a7;
            margin-bottom: 2.5rem;
        }
        
        /* Footer */
        .footer {
            background: #2d3748;
            color: white;
            padding: 3rem 0 1.5rem;
        }
        
        .footer-link {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: all 0.2s ease;
        }
        
        .footer-link:hover {
            color: white;
        }
        
        @media (max-width: 768px) {
            body {
                padding-top: 70px;
            }
            .hero-title {
                font-size: 2.5rem;
            }
            .hero-subtitle {
                font-size: 1.2rem;
            }
            .section-title {
                font-size: 2rem;
            }
            .stat-number {
                font-size: 2.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="landing-navbar" id="navbar">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center py-3">
                <a href="{{ url('/') }}" class="navbar-brand-text text-decoration-none">
                    📊 JobTracker
                </a>
                
                <div class="d-none d-md-flex align-items-center gap-4">
                    <a href="{{ url('/') }}" class="nav-link-custom text-decoration-none">Home</a>
                    <a href="#features" class="nav-link-custom text-decoration-none">Features</a>
                    <a href="{{ route('jobs.index') }}" class="nav-link-custom text-decoration-none">Jobs</a>
                    <a href="#contact" class="nav-link-custom text-decoration-none">Contact</a>
                </div>
                
                <div class="d-flex align-items-center gap-2">
                    @auth
                        <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('team.dashboard') }}" class="btn btn-nav signup">
                            <i class="bi bi-speedometer2 me-1"></i>Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-nav login">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-nav signup">Sign Up</a>
                    @endauth
                </div>
                
                <!-- Mobile Menu Toggle -->
                <button class="btn d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#mobileMenu">
                    <i class="bi bi-list" style="font-size: 1.5rem; color: #667eea;"></i>
                </button>
            </div>
            
            <!-- Mobile Menu -->
            <div class="collapse d-md-none" id="mobileMenu">
                <div class="d-flex flex-column gap-2 pb-3">
                    <a href="{{ url('/') }}" class="nav-link-custom text-decoration-none">Home</a>
                    <a href="#features" class="nav-link-custom text-decoration-none">Features</a>
                    <a href="{{ route('jobs.index') }}" class="nav-link-custom text-decoration-none">Jobs</a>
                    <a href="#contact" class="nav-link-custom text-decoration-none">Contact</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 hero-content">
                    <h1 class="hero-title">Track Every Job Application Effortlessly</h1>
                    <p class="hero-subtitle">Manage clients, assign tasks, and monitor team performance with our powerful job application tracking system.</p>
                    <div class="cta-buttons">
                        <a href="{{ route('jobs.index') }}" class="btn btn-hero primary">
                            <i class="bi bi-search"></i>
                            Search Jobs
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-hero secondary">
                            <i class="bi bi-box-arrow-in-right"></i>
                            Get Started
                        </a>
                        <a href="#features" class="btn btn-hero secondary">
                            <i class="bi bi-play-circle"></i>
                            Learn More
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 text-center mt-5 mt-lg-0">
                    <div style="font-size: 15rem; opacity: 0.9;">📊</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section" id="features">
        <div class="container">
            <h2 class="section-title">Powerful Features</h2>
            <p class="section-subtitle">Everything you need to manage job applications at scale</p>
            
            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">👥</div>
                        <h3 class="feature-title">Client Management</h3>
                        <p class="feature-description">Organize and manage multiple clients with ease. Track contact information, notes, and Google Sheets integration.</p>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">📋</div>
                        <h3 class="feature-title">Task Assignment</h3>
                        <p class="feature-description">Assign clients to team members with specific targets and limits. Monitor progress in real-time.</p>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">💼</div>
                        <h3 class="feature-title">Application Tracking</h3>
                        <p class="feature-description">Log every job application with detailed information including job title, company, status, and resume files.</p>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">📊</div>
                        <h3 class="feature-title">Google Sheets Sync</h3>
                        <p class="feature-description">Automatically sync applications to client-specific Google Sheets for seamless collaboration.</p>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">💰</div>
                        <h3 class="feature-title">Earnings Tracking</h3>
                        <p class="feature-description">Monitor team member earnings with detailed reports, charts, and performance analytics.</p>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">⚡</div>
                        <h3 class="feature-title">Advanced Controls</h3>
                        <p class="feature-description">Pause/resume applications, set limits, and maintain full control over your workflow.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-6 mb-4 mb-md-0">
                    <div class="stat-item">
                        <div class="stat-number">10K+</div>
                        <div class="stat-label">Applications Tracked</div>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-4 mb-md-0">
                    <div class="stat-item">
                        <div class="stat-number">500+</div>
                        <div class="stat-label">Active Clients</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <div class="stat-number">50+</div>
                        <div class="stat-label">Team Members</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item">
                        <div class="stat-number">99%</div>
                        <div class="stat-label">Success Rate</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <h2 class="cta-title">Ready to Get Started?</h2>
            <p class="cta-text">Join hundreds of teams already using JobTracker to streamline their application process</p>
            <a href="{{ route('login') }}" class="btn btn-hero primary" style="background: linear-gradient(135deg, #667eea, #764ba2); color: white;">
                <i class="bi bi-rocket-takeoff"></i>
                Start Tracking Now
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mb-3 mb-md-0">
                    <h5 class="mb-3">JobTracker</h5>
                    <p class="text-white-50">Streamline your job application tracking process with powerful tools and insights.</p>
                </div>
                <div class="col-md-3 mb-3 mb-md-0">
                    <h6 class="mb-3">Quick Links</h6>
                    <div class="d-flex flex-column gap-2">
                        <a href="{{ route('login') }}" class="footer-link">Login</a>
                        <a href="{{ route('register') }}" class="footer-link">Register</a>
                    </div>
                </div>
                <div class="col-md-3" id="contact">
                    <h6 class="mb-3">Contact</h6>
                    <div class="d-flex flex-column gap-2">
                        <a href="mailto:support@jobtracker.com" class="footer-link">
                            <i class="bi bi-envelope me-2"></i>support@jobtracker.com
                        </a>
                    </div>
                </div>
            </div>
            <hr class="my-4" style="border-color: rgba(255,255,255,0.1);">
            <div class="text-center text-white-50">
                <small>&copy; {{ date('Y') }} JobTracker. All rights reserved.</small>
            </div>
        </div>
    </footer>

    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
        
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    const offset = 80;
                    const targetPosition = target.offsetTop - offset;
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                    
                    // Close mobile menu if open
                    const mobileMenu = document.getElementById('mobileMenu');
                    if (mobileMenu.classList.contains('show')) {
                        bootstrap.Collapse.getInstance(mobileMenu).hide();
                    }
                }
            });
        });
    </script>
</body>
</html>
