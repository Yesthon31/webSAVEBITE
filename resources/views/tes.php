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
    <style>
        html {
            scroll-behavior: smooth;
            height: 100%;
            overflow-y: auto;
            scroll-snap-type: y mandatory;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
            background-color: #ffffff;
        }

        .section {
            width: 100%;
            height: 100vh;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            will-change: transform;
            transform-style: preserve-3d;
            perspective: 1000px;
            scroll-snap-align: start;
            scroll-snap-stop: always;
        }

        .section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(
                to bottom,
                rgba(253, 184, 19, 0.4) 0%,
                rgba(253, 184, 19, 0.2) 50%,
                rgba(253, 184, 19, 0.4) 100%
            );
            mix-blend-mode: multiply;
            z-index: 2;
            transition: opacity 0.5s ease;
        }

        .section::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.2);
            z-index: 1;
            pointer-events: none;
        }

        .section.active::before {
            opacity: 1;
        }

        #hero {
            background-image: url('/images/1.png');
            background-size: 120% auto;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            z-index: 3;
        }

        #features {
            background-image: url('/images/2.png');
            background-size: 120% auto;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            z-index: 2;
        }

        #mission {
            background-image: url('/images/3.png');
            background-size: 120% auto;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            z-index: 1;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(253, 184, 19, 0.3);
            mix-blend-mode: soft-light;
            z-index: 3;
        }

        .section:not(.active) .overlay {
            opacity: 0.4;
        }

        .section.active .overlay {
            opacity: 1;
        }

        .content {
            z-index: 4;
            position: relative;
            padding: 2rem;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            color: white;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .section.active .content {
            opacity: 1;
            transform: translateY(0);
        }

        .btn {
            padding: 1rem 2rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
            text-decoration: none;
        }

        .btn-primary {
            background: #3B82F6;
            color: white;
            border: none;
        }

        .btn-primary:hover {
            background: #2563EB;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: transparent;
            color: white;
            border: 2px solid white;
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 2rem;
            border-radius: 1rem;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            transform: translateY(0);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            opacity: 1 !important;
        }

        .feature-card * {
            opacity: 1 !important;
        }

        .feature-card:hover {
            transform: translateY(-15px) scale(1.02);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            height: auto;
            max-width: 1200px;
            margin: 0 auto;
        }

        @media (max-width: 768px) {
            .features-grid {
                grid-template-columns: 1fr;
            }
        }

        .mission-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            margin-top: 2rem;
        }

        @media (max-width: 768px) {
            .mission-stats {
                grid-template-columns: 1fr;
            }
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.1);
            padding: 2rem;
            border-radius: 1rem;
            backdrop-filter: blur(10px);
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            transform: translateY(0);
            opacity: 1 !important;
        }

        .stat-card * {
            opacity: 1 !important;
        }

        .stat-card:hover {
            transform: translateY(-10px);
            background: rgba(255, 255, 255, 0.15);
        }

        .nav-dots {
            position: fixed;
            right: 2rem;
            top: 50%;
            transform: translateY(-50%);
            z-index: 100;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .nav-dot {
            width: 12px;
            height: 12px;
            background: rgba(255, 255, 255, 0.5);
            border: 2px solid transparent;
            border-radius: 50%;
            margin: 0.5rem 0;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .nav-dot:hover {
            transform: scale(1.2);
            background: rgba(255, 255, 255, 0.8);
        }

        .nav-dot.active {
            background: white;
            border-color: #3B82F6;
            transform: scale(1.3);
        }

        .scroll-indicator {
            position: absolute;
            bottom: 40px;
            left: 50%;
            transform: translateX(-50%);
            animation: bounce 2s infinite;
            color: #3e6ff4;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0) translateX(-50%);
            }
            40% {
                transform: translateY(-30px) translateX(-50%);
            }
            60% {
                transform: translateY(-15px) translateX(-50%);
            }
        }

        .section-title {
            background: linear-gradient(45deg,rgb(255, 255, 255),rgb(0, 0, 0));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-fill-color: transparent;
        }

        /* Mobile Responsive Styles */
        @media (max-width: 768px) {
            .section {
                padding: 1rem;
                height: 100vh;
                min-height: -webkit-fill-available; /* For iOS */
            }

            .content {
                padding: 1rem;
            }

            .features-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
                padding: 0 1rem;
            }

            .mission-stats {
                grid-template-columns: 1fr;
                gap: 1rem;
                padding: 0 1rem;
            }

            .feature-card {
                padding: 1.5rem;
            }

            .stat-card {
                padding: 1.5rem;
            }

            .nav-dots {
                right: 0.5rem;
            }

            .nav-dot {
                width: 8px;
                height: 8px;
                margin: 0.25rem 0;
            }

            /* Adjust font sizes for mobile */
            h1.text-6xl {
                font-size: 2.5rem !important;
                line-height: 1.2 !important;
            }

            h2.text-5xl {
                font-size: 2rem !important;
                line-height: 1.2 !important;
            }

            .text-xl {
                font-size: 1rem !important;
                line-height: 1.5 !important;
            }

            .text-2xl {
                font-size: 1.25rem !important;
                line-height: 1.4 !important;
            }

            /* Adjust button spacing and size */
            .btn {
                padding: 0.75rem 1.5rem;
                font-size: 1rem;
            }

            .space-x-6 > * + * {
                margin-left: 0.75rem;
            }

            /* Adjust emoji size in feature cards */
            .feature-card .text-5xl {
                font-size: 2.5rem !important;
            }

            /* Adjust stat numbers size */
            .stat-card .text-5xl {
                font-size: 2rem !important;
            }

            /* Footer adjustments */
            footer .space-x-8 {
                gap: 1rem;
                flex-wrap: wrap;
                justify-content: center;
            }

            footer a {
                padding: 0.5rem;
            }
        }

        /* Fix for iOS vh issue */
        @supports (-webkit-touch-callout: none) {
            .section {
                height: -webkit-fill-available;
            }
        }
    </style>
</head>
<body class="overflow-x-hidden">
    <div class="nav-dots">
        <div class="nav-dot active" data-section="hero"></div>
        <div class="nav-dot" data-section="features"></div>
        <div class="nav-dot" data-section="mission"></div>
    </div>

    <!-- Hero Section -->
    <section id="hero" class="section">
        <div class="overlay"></div>
        <div class="content text-white px-4">
            <h1 class="text-4xl md:text-6xl lg:text-8xl font-bold mb-6 leading-tight">
                Selamat Datang di SaveBite
            </h1>
            <p class="text-lg md:text-xl lg:text-2xl mb-8 md:mb-12 leading-relaxed">
                Platform Inovatif untuk Mengurangi Pemborosan Makanan
            </p>
            <div class="flex flex-wrap gap-4 justify-center md:justify-start">
                <a href="{{ url('/login') }}" class="btn btn-primary">
                    Masuk
                </a>
                <a href="{{ url('/register') }}" class="btn btn-secondary">
                    Daftar
                </a>
            </div>
        </div>
        <div class="scroll-indicator text-3xl md:text-4xl">↓</div>
    </section>

    <!-- Features Section -->
    <section id="features" class="section">
        <div class="overlay"></div>
        <div class="content">
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-8 md:mb-12 text-center text-white">
                Kenapa Memilih SaveBite?
            </h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="text-4xl md:text-5xl mb-4 md:mb-6">🍽️</div>
                    <h3 class="text-xl md:text-2xl font-semibold mb-3 md:mb-4 text-gray-800">Manajemen Makanan Pintar</h3>
                    <p class="text-base md:text-lg text-gray-600">Pantau stok dan tanggal kadaluarsa makanan Anda dengan mudah</p>
                </div>
                <div class="feature-card">
                    <div class="text-4xl md:text-5xl mb-4 md:mb-6">📝</div>
                    <h3 class="text-xl md:text-2xl font-semibold mb-3 md:mb-4 text-gray-800">Inspirasi Resep</h3>
                    <p class="text-base md:text-lg text-gray-600">Temukan berbagai resep kreatif untuk bahan makanan Anda</p>
                </div>
                <div class="feature-card">
                    <div class="text-4xl md:text-5xl mb-4 md:mb-6">⏰</div>
                    <h3 class="text-xl md:text-2xl font-semibold mb-3 md:mb-4 text-gray-800">Notifikasi Cerdas</h3>
                    <p class="text-base md:text-lg text-gray-600">Dapatkan pengingat sebelum makanan Anda kadaluarsa</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission Section -->
    <section id="mission" class="section">
        <div class="overlay"></div>
        <div class="content text-center text-white">
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-6 md:mb-8">Misi Kami</h2>
            <p class="text-base md:text-xl max-w-3xl mx-auto mb-8 md:mb-12 px-4">
                SaveBite berkomitmen untuk menciptakan masa depan yang lebih berkelanjutan dengan mengurangi pemborosan makanan. 
                Bersama-sama, kita dapat membuat perubahan positif untuk lingkungan dan masyarakat.
            </p>
            <div class="mission-stats">
                <div class="stat-card">
                    <div class="text-3xl md:text-4xl lg:text-5xl font-bold mb-2">10,000+</div>
                    <p class="text-base md:text-lg">Pengguna Aktif</p>
                </div>
                <div class="stat-card">
                    <div class="text-3xl md:text-4xl lg:text-5xl font-bold mb-2">50,000+</div>
                    <p class="text-base md:text-lg">Kg Makanan Terselamatkan</p>
                </div>
                <div class="stat-card">
                    <div class="text-3xl md:text-4xl lg:text-5xl font-bold mb-2">1,000+</div>
                    <p class="text-base md:text-lg">Resep Tersedia</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-gray-800 to-gray-900 text-white py-6">
        <div class="container mx-auto px-4 text-center">
            <p class="mb-4 text-sm">© 2024 SaveBite. Hak Cipta Dilindungi.</p>
            <div class="flex justify-center space-x-8">
                <a href="#" class="text-sm hover:text-blue-400 transition-colors duration-300">Tentang Kami</a>
                <a href="#" class="text-sm hover:text-blue-400 transition-colors duration-300">Kontak</a>
                <a href="#" class="text-sm hover:text-blue-400 transition-colors duration-300">Kebijakan Privasi</a>
            </div>
        </div>
    </footer>

    <script>
        // Initialize GSAP
        gsap.registerPlugin(ScrollTrigger);

        // Enhanced Parallax Effect
        const sections = document.querySelectorAll('.section');
        sections.forEach((section, index) => {
            // Parallax effect
            gsap.to(section, {
                scrollTrigger: {
                    trigger: section,
                    start: "top top",
                    end: "bottom top",
                    scrub: 2,
                    toggleActions: "play none none reverse"
                },
                backgroundPosition: `center ${80}%`,
                ease: "none"
            });

            // Gradient animation
            gsap.to(section.querySelector('.section::before'), {
                scrollTrigger: {
                    trigger: section,
                    start: "top bottom",
                    end: "bottom top",
                    scrub: 1
                },
                opacity: 0.8,
                ease: "none"
            });

            // Scale effect
            gsap.to(section, {
                scrollTrigger: {
                    trigger: section,
                    start: "top bottom",
                    end: "bottom top",
                    scrub: 1
                },
                backgroundSize: "130% auto",
                ease: "none"
            });

            ScrollTrigger.create({
                trigger: section,
                start: "top center",
                end: "bottom center",
                onEnter: () => {
                    section.classList.add('active');
                    updateNavDots(section.id);
                },
                onLeave: () => {
                    if (!section.classList.contains('features') && !section.classList.contains('mission')) {
                        section.classList.remove('active');
                    }
                },
                onEnterBack: () => {
                    section.classList.add('active');
                    updateNavDots(section.id);
                },
                onLeaveBack: () => {
                    if (!section.classList.contains('features') && !section.classList.contains('mission')) {
                        section.classList.remove('active');
                    }
                }
            });
        });

        // Feature Cards Animation
        const featureCards = document.querySelectorAll(".feature-card");
        featureCards.forEach((card, index) => {
            gsap.from(card, {
                scrollTrigger: {
                    trigger: card,
                    start: "top bottom-=100",
                    toggleActions: "play none none reverse"
                },
                y: 50,
                duration: 0.8,
                delay: index * 0.2,
                ease: "power2.out"
            });
        });

        // Stats Cards Animation
        const statCards = document.querySelectorAll(".stat-card");
        statCards.forEach((card, index) => {
            gsap.from(card, {
                scrollTrigger: {
                    trigger: card,
                    start: "top bottom-=100",
                    toggleActions: "play none none reverse"
                },
                y: 50,
                duration: 0.8,
                delay: index * 0.2,
                ease: "power2.out"
            });
        });

        // Navigation Dots
        const navDots = document.querySelectorAll('.nav-dot');

        function updateNavDots(sectionId) {
            navDots.forEach(dot => {
                dot.classList.remove('active');
                if (dot.dataset.section === sectionId) {
                    dot.classList.add('active');
                }
            });
        }

        // Smooth scroll on dot click
        navDots.forEach(dot => {
            dot.addEventListener('click', () => {
                const sectionId = dot.dataset.section;
                const targetSection = document.getElementById(sectionId);
                smoothScroll(targetSection);
            });
        });

        // Initial section activation
        function activateInitialSection() {
            const scrollPosition = window.scrollY;
            sections.forEach(section => {
                const rect = section.getBoundingClientRect();
                if (rect.top <= window.innerHeight / 2 && rect.bottom >= window.innerHeight / 2) {
                    section.classList.add('active');
                    updateNavDots(section.id);
                }
            });
        }

        // Call on load
        activateInitialSection();

        // Update on scroll
        window.addEventListener('scroll', () => {
            requestAnimationFrame(activateInitialSection);
        });
    </script>
</body>
</html>
