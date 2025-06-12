<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">
    <title>Login - SaveBite</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #f5f5f5;
            min-height: 100vh;
            display: flex;
            margin: 0;
        }

        .split-container {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }

        .left-side {
            flex: 1;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
        }

        .right-side {
            flex: 1;
            background: #4b6930;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            color: white;
            position: relative;
            overflow: hidden;
            animation: slideInRight 1s ease-out;
        }

        @keyframes slideInRight {
            0% {
                transform: translateX(100%);
            }
            100% {
                transform: translateX(0);
            }
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            opacity: 0;
            transform: translateX(-20px);
            animation: fadeInLeft 0.8s ease-out forwards;
        }

        @keyframes fadeInLeft {
            0% {
                opacity: 0;
                transform: translateX(-20px);
            }
            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .welcome-container {
            width: 100%;
            max-width: 500px;
            text-align: center;
            position: relative;
            z-index: 2;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.8s ease-out forwards;
            animation-delay: 0.5s;
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo {
            width: 120px;
            height: auto;
            margin-bottom: 20px;
        }

        h1 {
            color: #333;
            font-size: 32px;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .welcome-title {
            color: #ffffff;
            font-size: 36px;
            margin-bottom: 20px;
        }

        .welcome-text {
            color: rgba(255, 255, 255, 0.9);
            font-size: 16px;
            line-height: 1.8;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-size: 14px;
            color: #666;
            display: block;
            margin-bottom: 8px;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #eee;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s;
        }

        input[type="text"]:focus, input[type="password"]:focus {
            border-color: #4b6930;
            outline: none;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #4b6930;
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s;
        }

        button:hover {
            background: #5c8039;
            transform: translateY(-2px);
        }

        .error {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
        }

        .register-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }

        .register-link a {
            color: #4b6930;
            text-decoration: none;
            font-weight: 500;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        .feature-list {
            list-style: none;
            text-align: left;
            margin-top: 30px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            color: rgba(255, 255, 255, 0.9);
        }

        .feature-icon {
            margin-right: 15px;
            font-size: 20px;
            color: #FDB813;
        }

        .background-pattern {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background-image: radial-gradient(rgba(255, 255, 255, 0.1) 2px, transparent 2px);
            background-size: 30px 30px;
            opacity: 0.5;
            animation: patternMove 15s linear infinite;
        }

        @keyframes patternMove {
            0% {
                background-position: 0 0;
            }
            100% {
                background-position: 30px 30px;
            }
        }

        @media (max-width: 768px) {
            .split-container {
                flex-direction: column;
            }
            
            .left-side, .right-side {
                flex: none;
                width: 100%;
                padding: 30px 20px;
            }

            .right-side {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="split-container">
        <div class="left-side">
            <div class="login-container">   
                <h1>Selamat Datang</h1>
                <p style="color: #666; margin-bottom: 30px;">Masuk ke akun Anda untuk melanjutkan</p>

                <form action="/login" method="POST" class="login-form">
                    @csrf
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" 
                            value="{{ old('username') }}"
                            class="@error('username') is-invalid @enderror" 
                            required 
                            minlength="3"
                            autocomplete="username"
                            placeholder="Masukkan username Anda">
                        @error('username')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" 
                            class="@error('password') is-invalid @enderror" 
                            required 
                            minlength="8"
                            autocomplete="current-password"
                            placeholder="Masukkan password Anda">
                        @error('password')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    @if(session('error'))
                        <div class="error">
                            {{ session('error') }}
                        </div>
                    @endif

                    <button type="submit">Masuk</button>
                </form>

                <div class="register-link">
                    Belum punya akun? <a href="/register">Daftar Sekarang</a>
                </div>
            </div>
        </div>

        <div class="right-side">
            <div class="background-pattern"></div>
            <div class="welcome-container">
                <h2 class="welcome-title">SaveBite</h2>
                <p class="welcome-text">
                    Selamat datang di SaveBite, solusi pintar untuk mengelola makanan Anda. 
                    Bergabunglah dengan komunitas kami dan mulai perjalanan menuju gaya hidup 
                    yang lebih berkelanjutan.
                </p>

                <script src="https://unpkg.com/@dotlottie/player-component@2.7.12/dist/dotlottie-player.mjs" type="module"></script>
                <div style="display: flex; justify-content: center; align-items: center;">
                    <dotlottie-player src="https://lottie.host/943a196b-3e72-4b5c-8d47-21d9a3791238/eUkZmAPLY0.lottie" background="transparent" speed="1" style="width: 300px; height: 300px" loop autoplay></dotlottie-player>
                </div>

            </div>
        </div>
    </div>
</body>
</html>
