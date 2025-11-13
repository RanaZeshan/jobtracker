<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Search - Coming Soon | JobTracker</title>
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }
        
        body::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 800px;
            height: 800px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            animation: float 20s infinite ease-in-out;
        }
        
        body::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -10%;
            width: 600px;
            height: 600px;
            background: rgba(255,255,255,0.08);
            border-radius: 50%;
            animation: float 15s infinite ease-in-out reverse;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-50px) rotate(5deg); }
        }
        
        .coming-soon-container {
            position: relative;
            z-index: 1;
            text-align: center;
            color: white;
            padding: 2rem;
            max-width: 900px;
        }
        
        .icon-wrapper {
            font-size: 8rem;
            margin-bottom: 2rem;
            animation: bounce 2s infinite;
        }
        
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
        
        .main-title {
            font-size: 4rem;
            font-weight: 900;
            margin-bottom: 1rem;
            text-shadow: 0 4px 20px rgba(0,0,0,0.2);
        }
        
        .subtitle {
            font-size: 1.5rem;
            opacity: 0.95;
            margin-bottom: 3rem;
            font-weight: 400;
        }
        
        .countdown-container {
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            border-radius: 30px;
            padding: 3rem 2rem;
            margin-bottom: 3rem;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
            border: 1px solid rgba(255,255,255,0.2);
        }
        
        .countdown-title {
            font-size: 1.3rem;
            margin-bottom: 2rem;
            opacity: 0.9;
            font-weight: 600;
        }
        
        .countdown {
            display: flex;
            justify-content: center;
            gap: 2rem;
            flex-wrap: wrap;
        }
        
        .countdown-item {
            background: rgba(255,255,255,0.2);
            border-radius: 20px;
            padding: 1.5rem 2rem;
            min-width: 120px;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255,255,255,0.3);
            transition: all 0.3s ease;
        }
        
        .countdown-item:hover {
            transform: translateY(-5px);
            background: rgba(255,255,255,0.25);
        }
        
        .countdown-number {
            font-size: 3.5rem;
            font-weight: 900;
            display: block;
            line-height: 1;
            margin-bottom: 0.5rem;
        }
        
        .countdown-label {
            font-size: 1rem;
            opacity: 0.9;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }
        
        .notify-section {
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            border-radius: 30px;
            padding: 2.5rem 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
            border: 1px solid rgba(255,255,255,0.2);
        }
        
        .notify-title {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            font-weight: 700;
        }
        
        .notify-form {
            display: flex;
            gap: 1rem;
            max-width: 500px;
            margin: 0 auto;
            flex-wrap: wrap;
            justify-content: center;
        }
        
        .notify-input {
            flex: 1;
            min-width: 250px;
            padding: 1rem 1.5rem;
            border-radius: 50px;
            border: 2px solid rgba(255,255,255,0.3);
            background: rgba(255,255,255,0.2);
            color: white;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .notify-input::placeholder {
            color: rgba(255,255,255,0.7);
        }
        
        .notify-input:focus {
            outline: none;
            border-color: white;
            background: rgba(255,255,255,0.25);
        }
        
        .notify-btn {
            padding: 1rem 2.5rem;
            border-radius: 50px;
            background: white;
            color: #667eea;
            border: none;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .notify-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(255,255,255,0.3);
        }
        
        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: white;
            text-decoration: none;
            font-size: 1.1rem;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            background: rgba(255,255,255,0.2);
            border: 2px solid rgba(255,255,255,0.3);
            transition: all 0.3s ease;
            font-weight: 600;
        }
        
        .back-btn:hover {
            background: rgba(255,255,255,0.3);
            transform: translateY(-3px);
            color: white;
        }
        
        @media (max-width: 768px) {
            .main-title {
                font-size: 2.5rem;
            }
            .subtitle {
                font-size: 1.2rem;
            }
            .icon-wrapper {
                font-size: 5rem;
            }
            .countdown {
                gap: 1rem;
            }
            .countdown-item {
                min-width: 90px;
                padding: 1rem 1.5rem;
            }
            .countdown-number {
                font-size: 2.5rem;
            }
            .notify-form {
                flex-direction: column;
            }
            .notify-input {
                min-width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="coming-soon-container">
        <div class="icon-wrapper">🚀</div>
        
        <h1 class="main-title">Coming Soon</h1>
        <p class="subtitle">We're building something amazing! Our job search feature will be live soon.</p>
        
        <div class="countdown-container">
            <h2 class="countdown-title">Launch Countdown</h2>
            <div class="countdown" id="countdown">
                <div class="countdown-item">
                    <span class="countdown-number" id="days">00</span>
                    <span class="countdown-label">Days</span>
                </div>
                <div class="countdown-item">
                    <span class="countdown-number" id="hours">00</span>
                    <span class="countdown-label">Hours</span>
                </div>
                <div class="countdown-item">
                    <span class="countdown-number" id="minutes">00</span>
                    <span class="countdown-label">Minutes</span>
                </div>
                <div class="countdown-item">
                    <span class="countdown-number" id="seconds">00</span>
                    <span class="countdown-label">Seconds</span>
                </div>
            </div>
        </div>
        
        

    <script>
        // Set the launch date from Laravel
        const launchDate = new Date("{{ $launchDate }}").getTime();
        
        function updateCountdown() {
            const now = new Date().getTime();
            const distance = launchDate - now;
            
            if (distance < 0) {
                document.getElementById('countdown').innerHTML = '<div class="countdown-item"><span class="countdown-number">🎉</span><span class="countdown-label">We\'re Live!</span></div>';
                return;
            }
            
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
            document.getElementById('days').textContent = String(days).padStart(2, '0');
            document.getElementById('hours').textContent = String(hours).padStart(2, '0');
            document.getElementById('minutes').textContent = String(minutes).padStart(2, '0');
            document.getElementById('seconds').textContent = String(seconds).padStart(2, '0');
        }
        
        // Update countdown every second
        updateCountdown();
        setInterval(updateCountdown, 1000);
        
        function handleNotify(event) {
            event.preventDefault();
            const email = event.target.querySelector('input[type="email"]').value;
            alert('Thanks! We\'ll notify you at ' + email + ' when we launch! 🎉');
            event.target.reset();
        }
    </script>
</body>
</html>
