<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Add New Food</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="icon" href="/images/logoSaveBite.png">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <style>
        :root {
            --primary-green: #4CAF50;
            --light-green: #81C784;
            --white: #ffffff;
            --gray-bg: #f5f5f5;
            --text-dark: #333333;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--gray-bg);
            color: var(--text-dark);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .form-container {
            background-color: var(--white);
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(76, 175, 80, 0.1);
            width: 100%;
            max-width: 450px;
            margin: 50px auto;
        }

        .form-container h3 {
            font-size: 1.8em;
            margin-bottom: 1.5rem;
            color: var(--text-dark);
            text-align: center;
        }

        .form-container label {
            display: block;
            margin-bottom: 8px;
            font-size: 1em;
            font-weight: 500;
            color: var(--text-dark);
        }

        .form-container input[type="text"],
        .form-container input[type="number"],
        .form-container input[type="date"],
        .form-container select {
            width: 100%;
            padding: 12px;
            font-size: 1em;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            margin-bottom: 1.5rem;
            background-color: var(--white);
            color: var(--text-dark);
            transition: all 0.3s ease;
        }

        .form-container input[type="text"]:focus,
        .form-container input[type="number"]:focus,
        .form-container input[type="date"]:focus,
        .form-container select:focus {
            border-color: var(--primary-green);
            box-shadow: 0 0 0 2px rgba(76, 175, 80, 0.1);
            outline: none;
        }

        .form-container button[type="submit"] {
            background: var(--primary-green);
            color: var(--white);
            padding: 14px 28px;
            font-size: 1.1em;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            font-weight: 500;
            margin-top: 1rem;
        }

        .form-container button[type="submit"]:hover {
            background: var(--light-green);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(76, 175, 80, 0.2);
        }

        .error {
            color: #f44336;
            font-weight: 500;
            margin-top: 10px;
        }

        .success-message {
            background-color: var(--primary-green);
            color: var(--white);
            padding: 1rem;
            border-radius: 8px;
            text-align: center;
            margin-top: 1.5rem;
            display: none;
            position: fixed;
            left: 50%;
            transform: translateX(-50%);
            bottom: 20px;
            width: 80%;
            max-width: 500px;
            animation: slideIn 0.3s ease-out;
            box-shadow: 0 4px 15px rgba(76, 175, 80, 0.2);
        }

        .success-message a {
            color: var(--white);
            text-decoration: none;
            font-weight: 500;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translate(-50%, 100px);
            }
            to {
                opacity: 1;
                transform: translate(-50%, 0);
            }
        }

        .back-button {
            position: absolute;
            top: 20px;
            left: 20px;
            background: var(--primary-green);
            color: var(--white);
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            font-size: 1em;
        }

        .back-button:hover {
            background: var(--light-green);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(76, 175, 80, 0.2);
            }

        @media (max-width: 768px) {
            .form-container {
                margin: 20px;
                padding: 1.5rem;
            }

            .form-container h3 {
                font-size: 1.5em;
            }
        }
    </style>
</head>
<body>
    <a href="{{ url('/dashboard') }}" class="back-button">
        <i class="fas fa-arrow-left"></i> Back
        </a>

    <div class="form-container">
        <h3>Add New Food</h3>

        @if(session('error'))
            <p class="error">{{ session('error') }}</p>
        @endif

        <form action="/foods" method="POST">
            @csrf
            <label for="name">Food Name</label>
            <input type="text" id="name" name="name" placeholder="Enter food name" required>
            
            <label for="category">Category</label>
            <select id="category" name="category_id" required>
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                @endforeach
            </select>

            <label for="quantity">Quantity</label>
            <input type="number" id="quantity" name="quantity" placeholder="Enter quantity" min="1" required>
            
            <label for="expiry_date">Expiry Date</label>
            <input type="date" id="expiry_date" name="expiry_date" required>

            <button type="submit">Add Food</button>
        </form>
    </div>

    @if(session('success'))
        <div class="success-message" id="successMessage">
            Food added successfully! <br> <a href="{{ url('/foods') }}">Click here to view foods</a>
        </div>
    @endif

    <script>
        @if(session('success'))
            document.getElementById('successMessage').style.display = 'block';
            setTimeout(function() {
                window.location.href = '{{ url('/foods') }}'; 
            }, 3000);
        @endif
    </script>
</body>
</html>
