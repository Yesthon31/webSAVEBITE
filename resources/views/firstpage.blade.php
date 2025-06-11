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
    <link rel="icon" href="/images/logoSaveBite.png">

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
            z-index: 1;
            font-weight: 900;
            font-family: 'Poppins', sans-serif;
            text-align: center;
            width: 100%;
            padding: 0 1rem;
            margin: 0;
            transform: translateY(-50px);
        }

        .tagline {
            position: relative;
            color: #fff;
            font-size: clamp(1.2rem, 2.5vw, 1.8rem);
            text-align: center;
            font-weight: 300;
            margin-top: -2rem;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
            opacity: 0.9;
            letter-spacing: 1px;
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 10;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            transform: translateY(-80px);
        }

        .hero-buttons {
            position: relative;
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: -0.5rem;
            z-index: 10;
        }

        .hero-btn {
            padding: 1rem 2.5rem;
            font-size: 1.2rem;
            font-weight: 600;
            border-radius: 50px;
            text-decoration: none;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            overflow: hidden;
            z-index: 10;
            pointer-events: auto;
        }

        .hero-btn-primary {
            background: #FDB813;
            color: #4b6930;
            border: none;
            box-shadow: 0 4px 15px rgba(253, 184, 19, 0.3);
            cursor: pointer;
        }

        .hero-btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(253, 184, 19, 0.4);
            background: #ffc107;
        }

        .hero-btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                90deg,
                transparent,
                rgba(255, 255, 255, 0.4),
                transparent
            );
            transition: 0.5s;
        }

        .hero-btn-primary:hover::before {
            left: 100%;
        }

        @media (max-width: 768px) {
            .hero-content {
                gap: 0.8rem;
                transform: translateY(-40px);
            }

            .tagline {
                font-size: 1rem;
                margin-top: -1.5rem;
                margin-bottom: 0.5rem;
                padding: 0 1rem;
            }

            .hero-buttons {
                margin-top: -0.25rem;
            }

            .hero-buttons {
                flex-direction: column;
                align-items: center;
                gap: 1rem;
            }

            .hero-btn {
                padding: 0.8rem 2rem;
                font-size: 1rem;
                width: 200px;
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            #text {
                font-size: clamp(3rem, 8vw, 8rem);
                transform: translateY(-30px);
            }

            .tagline {
                font-size: 0.9rem;
                margin-top: -1rem;
                margin-bottom: 0.25rem;
            }

            .hero-btn {
                padding: 0.7rem 1.8rem;
                font-size: 0.9rem;
                width: 180px;
            }

            .features-title,
            .about-title,
            .auth-title {
                font-size: clamp(1.8rem, 4vw, 2.5rem);
                margin-bottom: clamp(1.5rem, 4vh, 2.5rem);
            }

            .feature-card {
                padding: clamp(1rem, 3vw, 2rem);
            }

            .feature-title {
                font-size: clamp(1.2rem, 2.8vw, 1.6rem);
            }

            .feature-description {
                font-size: clamp(0.85rem, 1.8vw, 1rem);
            }

            .feature-icon {
                font-size: clamp(1.8rem, 4vw, 2.2rem);
            }

            .auth-container {
                padding: 2rem 1.5rem;
                margin: 2rem auto;
            }

            .feature-list {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .feature-item {
                gap: 1rem;
            }

            .feature-icon {
                width: 45px;
                height: 45px;
            }

            .feature-icon i {
                font-size: 1.3rem;
            }

            .feature-content h3 {
                font-size: 1.2rem;
            }

            .feature-content p {
                font-size: 0.9rem;
            }

            .about-description {
                font-size: clamp(0.9rem, 2.2vw, 1.1rem);
            }

            .about-point {
                padding: 1.5rem;
            }

            .about-point i {
                font-size: 1.8rem;
            }

            .about-point h3 {
                font-size: 1.2rem;
            }

            .about-point p {
                font-size: 0.9rem;
            }

            .footer-container {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .footer-col h3 {
                font-size: 1.3rem;
            }

            .footer-col p,
            .footer-links a,
            .footer-bottom p {
                font-size: 0.85rem;
            }

            .social-icon {
                width: 35px;
                height: 35px;
            }

            .social-icon i {
                font-size: 1rem;
            }
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
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 1rem;
            border-radius: 30px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 1200px;
            text-align: left;
            z-index: 6;
            margin: 6rem auto;
        }

        .auth-title {
            margin-top: 80px;
            color: white;
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 3rem;
            text-align: center;
        }

        .feature-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 3rem;
            padding: 1rem;
        }

        .feature-item {
            display: flex;
            align-items: flex-start;
            gap: 2rem;
            padding: 1rem;
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            background: #FDB813;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .feature-icon i {
            font-size: 1.8rem;
            color: #1a1a1a;
        }

        .feature-content h3 {
            color: #FDB813;
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .feature-content p {
            color: white;
            line-height: 1.7;
            font-size: 1.1rem;
            opacity: 0.9;
        }

        @media (max-width: 768px) {
            .auth-container {
                padding: 3rem 2rem;
                margin: 4rem auto;
                border-radius: 20px;
            }

            .auth-title {
                font-size: 2.5rem;
                margin-bottom: 2rem;
            }

            .feature-list {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .feature-item {
                gap: 1.5rem;
            }

            .feature-icon {
                width: 50px;
                height: 50px;
            }

            .feature-icon i {
                font-size: 1.5rem;
            }

            .feature-content h3 {
                font-size: 1.3rem;
            }

            .feature-content p {
                font-size: 1rem;
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

        .about-savebite {
            text-align: center;
            padding: 4rem 2rem;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            margin-bottom: 4rem;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .about-title {
            color: #ffffff;
            font-size: clamp(2rem, 5vw, 3rem);
            margin-bottom: 2rem;
            font-weight: 700;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
            position: relative;
            display: inline-block;
        }

        .about-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 3px;
            background: #FDB813;
            border-radius: 2px;
        }

        .about-description {
            color: rgba(255, 255, 255, 0.9);
            font-size: clamp(1rem, 2.5vw, 1.2rem);
            line-height: 1.8;
            max-width: 800px;
            margin: 0 auto 3rem;
        }

        .about-points {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .about-point {
            background: rgba(255, 255, 255, 0.1);
            padding: 2rem;
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .about-point:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.15);
        }

        .about-point i {
            color: #FDB813;
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .about-point h3 {
            color: #ffffff;
            font-size: 1.3rem;
            margin-bottom: 1rem;
        }

        .about-point p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 1rem;
            line-height: 1.6;
        }

        @media (max-width: 768px) {
            .about-savebite {
                padding: 2rem 1rem;
                margin: 2rem 1rem;
            }

            .about-points {
                grid-template-columns: 1fr;
            }
        }

        .footer-section {
            position: relative;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 4rem 2rem;
            color: white;
            margin-top: -1px;
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 3rem;
        }

        .footer-col {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .footer-col h3 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #FDB813;
        }

        .footer-col p {
            color: rgba(255, 255, 255, 0.8);
            line-height: 1.6;
            font-size: 1rem;
        }

        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-links li {
            margin-bottom: 0.8rem;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .footer-links a:hover {
            color: #FDB813;
            transform: translateX(5px);
        }

        .footer-social {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .social-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .social-icon:hover {
            background: #FDB813;
            transform: translateY(-3px);
        }

        .social-icon i {
            color: white;
            font-size: 1.2rem;
        }

        .footer-bottom {
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .footer-section {
                padding: 3rem 1rem;
            }

            .footer-container {
                gap: 2rem;
            }

            .footer-col {
                text-align: center;
            }

            .footer-social {
                justify-content: center;
            }
        }

    </style>

    <body>
        <section>
            <img src="{{ asset('images/bg.png') }}" id="bg">
            <img src="{{ asset('images/foods.png') }}" id="foods">
            <img src="{{ asset('images/road.png') }}" id="road">
            <div class="hero-content">
                <h1 id="text">SaveBite</h1>
                <p id="text2" class="tagline">Kelola Makananmu, Kurangi Limbah, Selamatkan Bumi</p>
                <div id="text3" class="hero-buttons">
                    <a href="{{ url('/login') }}" class="hero-btn hero-btn-primary z-index-10">Masuk Sekarang</a>
                </div>

            </div>

        </section>
        <section class="auth-section" style="height: 110vh;">
            <img src="{{ asset('images/newfood.png') }}" id="road2">
            <div class="features-container" id="features">
                <div class="about-savebite">
                    <h2 class="about-title">Apa itu SaveBite?</h2>
                    <p class="about-description">
                        SaveBite adalah platform inovatif yang dirancang untuk membantu Anda mengelola 
                        makanan dengan lebih bijak dan efisien.
                    </p>
                    <div class="about-points">
                        <div class="about-point">
                            <i class="fas fa-chart-pie"></i>
                            <h3>Manajemen Makanan</h3>
                            <p>Sistem manajemen makanan yang komprehensif untuk memantau stok dan 
                            tanggal kadaluarsa dengan mudah dan efisien.</p>
                        </div>
                        <div class="about-point">
                            <i class="fas fa-bell"></i>
                            <h3>Pengingat Cerdas</h3>
                            <p>Dapatkan notifikasi otomatis untuk makanan yang akan kadaluarsa, 
                            sehingga Anda dapat menggunakannya tepat waktu.</p>
                        </div>
                        <div class="about-point">
                            <i class="fas fa-leaf"></i>
                            <h3>Dampak Lingkungan</h3>
                            <p>Berkontribusi pada pengurangan limbah makanan dan menciptakan 
                            masa depan yang lebih berkelanjutan.</p>
                        </div>
                    </div>
                </div>

                
            </div>
          
        </section>

        <section class="login-section">
            <div class="auth-container" id="card">
                <h2 class="auth-title">Fitur Utama SaveBite</h2>
                <div class="feature-list">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="feature-content">
                            <h3>Inventori Digital</h3>
                            <p>Kelola stok makanan Anda dengan mudah. Catat tanggal kadaluarsa dan jumlah dengan sistem yang terorganisir.</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-bell"></i>
                        </div>
                        <div class="feature-content">
                            <h3>Notifikasi Pintar</h3>
                            <p>Dapatkan pengingat otomatis sebelum makanan kadaluarsa. Tidak ada lagi makanan yang terbuang sia-sia.</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-utensils"></i>
                        </div>
                        <div class="feature-content">
                            <h3>Rekomendasi Resep</h3>
                            <p>Temukan inspirasi masakan dari bahan yang Anda miliki. Maksimalkan penggunaan bahan yang ada.</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="feature-content">
                            <h3>Analisis & Statistik</h3>
                            <p>Pantau pola konsumsi dan lihat dampak positif Anda dalam mengurangi limbah makanan.</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-lightbulb"></i>
                        </div>
                        <div class="feature-content">
                            <h3>Tips & Panduan</h3>
                            <p>Akses berbagai tips penyimpanan dan panduan pengelolaan makanan yang tepat.</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="feature-content">
                            <h3>Komunitas</h3>
                            <p>Bergabung dengan komunitas peduli lingkungan. Berbagi tips dan pengalaman dengan pengguna lain.</p>
                        </div>
                    </div>
                </div>
            </div>
            <img src="{{ asset('images/footfood.png') }}" id="road3">
        </section>
        <footer class="footer-section">
            <div class="footer-container">
                <div class="footer-col">
                    <h3>SaveBite</h3>
                    <p>Platform inovatif untuk mengelola makanan dengan bijak dan mengurangi limbah makanan. Bersama kita bisa menciptakan masa depan yang lebih berkelanjutan.</p>
                    <div class="footer-social">
                        <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="footer-col">
                    <h3>Fitur</h3>
                    <ul class="footer-links">
                        <li><a href="#"><i class="fas fa-box"></i> Inventori Digital</a></li>
                        <li><a href="#"><i class="fas fa-bell"></i> Notifikasi</a></li>
                        <li><a href="#"><i class="fas fa-utensils"></i> Rekomendasi Resep</a></li>
                        <li><a href="#"><i class="fas fa-chart-line"></i> Statistik</a></li>
                        <li><a href="#"><i class="fas fa-users"></i> Komunitas</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h3>Tautan</h3>
                    <ul class="footer-links">
                        <li><a href="#"><i class="fas fa-info-circle"></i> Tentang Kami</a></li>
                        <li><a href="#"><i class="fas fa-shield-alt"></i> Kebijakan Privasi</a></li>
                        <li><a href="#"><i class="fas fa-file-alt"></i> Syarat & Ketentuan</a></li>
                        <li><a href="#"><i class="fas fa-question-circle"></i> FAQ</a></li>
                        <li><a href="#"><i class="fas fa-headset"></i> Bantuan</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h3>Kontak</h3>
                    <ul class="footer-links">
                        <li><a href="#"><i class="fas fa-envelope"></i> info@savebite.com</a></li>
                        <li><a href="#"><i class="fas fa-phone"></i> +62 812 3456 7890</a></li>
                        <li><a href="#"><i class="fas fa-map-marker-alt"></i> Jakarta, Indonesia</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 SaveBite. Hak Cipta Dilindungi. Dibuat dengan <i class="fas fa-heart" style="color: #FDB813;"></i> di Indonesia</p>
            </div>
        </footer>

        <script type="text/javascript">
            let features = document.getElementById('features');
            let bg = document.getElementById('bg');
            let mountain = document.getElementById('foods');
            let road = document.getElementById('road');
            let text = document.getElementById('text');
            let card = document.getElementById('card');
            let road2 = document.getElementById('road2');
            let road3 = document.getElementById('road3');
            let text2 = document.getElementById('text2');
            let text3 = document.getElementById('text3');
            window.addEventListener('scroll', function(){
                var value = window.scrollY;
                bg.style.top = value * 0.5 + 'px'
                mountain.style.bottom = value * 0.15 + 'px';
                road.style.top = value * 0.15 + 'px';
                text.style.top = value * 1 + 'px';
                text2.style.transform = `translateY(${value * 1}px)`;
                text3.style.transform = `translateY(${value * 1}px)`;
                card.style.bottom = value * 0.01 + 'px'
                road2.style.transform = `translateY(${value * 0.09}px)`;
                features.style.bottom = value * -0.11 + 'px'
               
                const road3Position = road3.getBoundingClientRect().top;
                if(road3Position < window.innerHeight * 0.8) {
                    road3.classList.add('active');
                    road3.style.transform = `translateY(${-value * 0.04}px) scale(${1 + value * 0.0001})`;
                }

         
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
