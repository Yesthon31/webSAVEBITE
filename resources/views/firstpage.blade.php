<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SaveBite - Reduce Food Waste</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');


        * {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }
        
        body{
            background-color: #4b6930;
            min-height: 1500px;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        section{
            position: relative;
            width: 100%;
            height: 100vh;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            padding: 0;
            background: #4b6930;
        }

        section::before{
            content: '';
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 200px;
            background: linear-gradient(to top,rgba(19, 19, 19, 0.64), transparent 50%);
            z-index: 3;
            opacity: 1;
        }
        section::after{
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #0a2a43;
            z-index: 2;
            mix-blend-mode: color-dodge;
        }
        #text{
            position: relative;
            color: #fff;
            font-size: clamp(4rem, 10vw, 10rem);
            margin-bottom: clamp(100px, 15vh, 200px);
            z-index: 1;
            font-weight: 900;
            font-family: 'Poppins', sans-serif;
            text-align: center;
            width: 100%;
            padding: 0 1rem;
        }



        section img{
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            pointer-events: none;
        }
        #road{
           z-index: 2 ;
           
        }
        #road2{
            position: absolute;
            top: -140px;
            left: 0;
            width: 100%;
            z-index: 1;
            transform: translateY(100px);
        }
        #moon{
            z-index: 3;
        }
        
        .auth-section {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            height: 100vh;
            background: #4b6930;
            padding: 0;
            margin: 0;
            z-index: 5;
            overflow: hidden;
        }

        .login-section {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            height: 100vh;
            background: #4b6930;
            padding: 0;
            margin: 0;
            z-index: 5;
        }

        .features-container {
            position: relative;
            width: 100%;
            max-width: 1200px;
            padding: 0 2rem;
            z-index: 6;
            color: white;
            text-align: center;
        }

        .features-title {
            font-size: clamp(2rem, 5vw, 3rem);
            font-weight: 700;
            margin-bottom: clamp(2rem, 5vh, 3rem);
            color:rgb(255, 255, 255);
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
            position: relative;
            display: inline-block;
        }

        .features-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 3px;
            background:rgb(255, 255, 255);
            border-radius: 2px;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(min(100%, 300px), 1fr));
            gap: clamp(1.5rem, 3vw, 2.5rem);
            margin: 0 auto;
            max-width: 1200px;
            width: 100%;
            padding: 1rem;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: clamp(1.5rem, 4vw, 2.5rem);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
            opacity: 0;
            transform: translateY(30px) rotateX(10deg);
            overflow: hidden;
            position: relative;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                90deg,
                transparent,
                rgba(255, 255, 255, 0.2),
                transparent
            );
            transition: 0.5s;
        }

        .feature-card:hover::before {
            left: 100%;
        }

        .feature-card.active {
            opacity: 1;
            transform: translateY(0) rotateX(0);
        }

        .feature-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 15px 45px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .feature-title {
            font-size: clamp(1.3rem, 3vw, 1.8rem);
            font-weight: 600;
            margin-bottom: clamp(1rem, 2vh, 1.5rem);
            color:rgb(255, 255, 255);
            position: relative;
            display: inline-block;
        }

        .feature-description {
            font-size: clamp(0.9rem, 2vw, 1.1rem);
            line-height: 1.8;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 1rem;
        }

        .feature-icon {
            font-size: clamp(2rem, 5vw, 2.5rem);
            color:rgb(255, 255, 255);
            margin-bottom: clamp(1rem, 3vh, 1.5rem);
            display: inline-block;
            transition: transform 0.3s ease;
        }

        .feature-card:hover .feature-icon {
            transform: scale(1.2) rotate(5deg);
        }

        .auth-container {
            position: relative;
            background: rgba(255, 255, 255, 0.9);
            padding: 2.5rem;
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
            z-index: 6;
            margin-top: 4rem;
            margin-bottom: 4rem;
        }

        .auth-title {
            color: #4b6930;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 2rem;
            margin-top: 0.5rem;
        }

        .auth-buttons {
            position: relative;
            display: flex;
            flex-direction: column;
            gap: 1rem;
            z-index: 7;
        }

        .auth-btn {
            position: relative;
            padding: 1rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            text-transform: uppercase;
            transition: all 0.3s ease;
            text-decoration: none;
            width: 100%;
            z-index: 8;
            cursor: pointer;
        }

        .auth-btn-primary {
            background: #FDB813;
            color: #4b6930;
            border: none;
        }

        .auth-btn-secondary {
            background: transparent;
            color: #4b6930;
            border: 2px solid #FDB813;
        }

        .auth-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .auth-text {
            color: #666;
            margin: 1.5rem 0;
            font-size: 1.1rem;
            line-height: 1.6;
            padding: 0 1rem;
        }

        @media (max-width: 768px) {
            .auth-container {
                padding: 1.5rem;
            }

            .auth-title {
                font-size: 1.75rem;
            }

            .auth-btn {
                padding: 0.8rem 1.5rem;
                font-size: 1rem;
            }

            .features-container {
                padding: 0 1rem;
            }

            .features-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
                padding: 1rem 0.5rem;
            }

            .feature-card {
                padding: 1.5rem;
                text-align: center;
            }

            .feature-card:hover {
                transform: translateY(-5px) scale(1.01);
            }

            .feature-icon {
                margin-bottom: 1rem;
            }
        }

        @media (max-width: 480px) {
            .features-container {
                padding: 0 0.5rem;
            }

            .feature-card {
                padding: 1.25rem;
            }

            .feature-description {
                font-size: 0.9rem;
            }
        }

        #road3 {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            z-index: 1;
            opacity: 0;
            transform: translateY(100px);
            transition: all 1.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        #road3.active {
            opacity: 1;
            transform: translateY(0);
        }

    </style>

    <body>
        <section>
            <img src="{{ asset('images/bg.png') }}" id="bg">
            <img src="{{ asset('images/foods.png') }}" id="foods">
            <img src="{{ asset('images/road.png') }}" id="road">
            <h1 id="text">SaveBite</h1>
        </section>
        <section class="auth-section" style="height: 110vh;">
            <img src="{{ asset('images/newfood.png') }}" id="road2">
            <div class="features-container" id="features">
                <h2 class="features-title">Fitur Utama SaveBite</h2>
                <div class="features-grid">
                    <div class="feature-card">
                        <i class="fas fa-tasks feature-icon"></i>
                        <h3 class="feature-title">Manajemen Makanan Pintar</h3>
                        <p class="feature-description">
                            Pantau stok dan tanggal kadaluarsa makanan Anda dengan mudah. 
                            Kelola makanan Anda secara efisien untuk mengurangi pemborosan.
                        </p>
                    </div>
                    <div class="feature-card">
                        <i class="fas fa-utensils feature-icon"></i>
                        <h3 class="feature-title">Inspirasi Resep</h3>
                        <p class="feature-description">
                            Akses resep sesuai dengan bahan makanan yang Anda miliki,
                            dengan integrasi dari AI.
                    </div>
                    <div class="feature-card">
                        <i class="fas fa-bell feature-icon"></i>
                        <h3 class="feature-title">Notifikasi Cerdas</h3>
                        <p class="feature-description">
                            Dapatkan pengingat otomatis sebelum makanan kadaluarsa.
                            Hindari pemborosan dengan sistem notifikasi yang terintegrasi.
                        </p>
                    </div>
                </div>
            </div>
          
        </section>

        <section class="login-section">
            <div class="auth-container" id="card">
                <h2 class="auth-title">SaveBite</h2>
                <p class="auth-text">
                    Bergabunglah dengan kami dalam misi mengurangi pemborosan makanan. 
                    Buat akun atau masuk untuk mulai menggunakan SaveBite.
                </p>
                <div class="auth-buttons">
                    <a href="{{ url('/login') }}" class="auth-btn auth-btn-primary">Masuk</a>
                    <a href="{{ url('/register') }}" class="auth-btn auth-btn-secondary">Daftar</a>
                </div>
            </div>
            <img src="{{ asset('images/footfood.png') }}" id="road3">
        </section>

        <script type="text/javascript">
            let features = document.getElementById('features');
            let bg = document.getElementById('bg');
            let mountain = document.getElementById('foods');
            let road = document.getElementById('road');
            let text = document.getElementById('text');
            let card = document.getElementById('card');
            let road2 = document.getElementById('road2');
            let road3 = document.getElementById('road3');
            window.addEventListener('scroll', function(){
                var value = window.scrollY;
                bg.style.top = value * 0.5 + 'px'
                mountain.style.bottom = value * 0.15 + 'px';
                road.style.top = value * 0.15 + 'px';
                text.style.top = value * 1 + 'px';
                card.style.bottom = value * 0.11 + 'px'
                road2.style.transform = `translateY(${value * 0.09}px)`;
                features.style.bottom = value * -0.11 + 'px'
                
                // Animate road3
                const road3Position = road3.getBoundingClientRect().top;
                if(road3Position < window.innerHeight * 0.8) {
                    road3.classList.add('active');
                    road3.style.transform = `translateY(${-value * 0.04}px) scale(${1 + value * 0.0001})`;
                }

                // Add animation for features
                const featuresContainer = document.querySelector('.features-container');
                const featureCards = document.querySelectorAll('.feature-card');
                const featuresPosition = featuresContainer.getBoundingClientRect().top;
                
                if(featuresPosition < window.innerHeight * 0.75) {
                    featuresContainer.classList.add('active');
                    featureCards.forEach(card => {
                        card.classList.add('active');
                    });
                }
            })

        </script>
    </body>

</html>
