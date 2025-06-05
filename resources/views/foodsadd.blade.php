<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Add New Food</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #404258;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .form-container {
            background-color: #474E68;
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 350px;
            text-align: center;
            margin: 50px auto;
        }
        .form-container h3 {
            font-size: 2em;
            margin-bottom: 20px;
            color:rgb(255, 255, 255);
        }
        .form-container label {
            display: block;
            margin-bottom: 10px;
            font-size: 18px;
            font-weight: bold;
            color: #fff;
            text-align: left;
        }
        .form-container input[type="text"],
        .form-container input[type="number"],
        .form-container input[type="date"],
        .form-container select {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: none;
            margin-bottom: 20px;
            background-color: #333333;
            color: white;
            transition: border-color 0.3s ease;
        }
        .form-container input[type="text"]:focus,
        .form-container input[type="number"]:focus,
        .form-container input[type="date"]:focus,
        .form-container select:focus {
            border: 1.5px solid #4caf50;
            outline: none;
        }
        .form-container button[type="submit"] {
            background: linear-gradient(90deg, #3e6ff4 0%, #5be9b9 100%);
            color: #fff;
            padding: 22px 38px;
            font-size: 1.2em;
            border: none;
            border-radius: 16px;
            cursor: pointer;
            transition: transform 0.25s, box-shadow 0.25s, background 0.25s, color 0.25s;
            width: 100%;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 8px 28px rgba(62,111,244,0.13);
            position: relative;
            overflow: hidden;
            font-weight: 600;
            letter-spacing: 1px;
            margin-top: 36px;
        }

        .form-container button[type="submit"]:hover {
            background: linear-gradient(90deg, #5be9b9 0%, #3e6ff4 100%);
            color: #232946;
            transform: scale(1.08);
            box-shadow: 0 16px 32px rgba(91,233,185,0.15);
        }
        p.error {
            color: #ff6b6b;
            font-weight: bold;
            margin-top: 10px;
        }
        .success-message {
            background-color: #4caf50;
            color: white;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            margin-top: 30px;
            display: none;
            position: fixed;
            left: 50%;
            transform: translateX(-50%);
            bottom: 20px;
            width: 80%;
            max-width: 500px;
            animation: slideIn 1s ease-out;
            cursor: pointer;
        }
        .success-message a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(100px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @media (max-width: 768px) {
            .form-container {
                padding: 25px;
            }
            .form-container h3 {
                font-size: 1.8em;
            }
        }
        .back button {
            background: linear-gradient(90deg, #3e6ff4 0%, #5be9b9 100%);
            color: #fff;
            padding: 10px 20px;
            font-size: 1em;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: transform 0.25s, box-shadow 0.25s;
        }
        .back button:hover {
            background: linear-gradient(90deg, #5be9b9 0%, #3e6ff4 100%);
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <div class="back" style="position: absolute; top: 20px; left: 20px;">
        <a href="{{ url('/dashboard') }}">
            <button>
                <
            </button>
        </a>
    </div>

    <div class="form-container">
        <h3>Add New Food</h3>

        @if(session('error'))
            <p class="error">{{ session('error') }}</p>
        @endif

        <form action="{{ url('/foods') }}" method="POST">
            @csrf
            <label for="name">Food Name:</label>
            <input type="text" id="name" name="name" placeholder="Enter food name" required>
            
            <label for="category">Category:</label>
            <select id="category" name="category_id" required>
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                @endforeach
            </select>

            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" placeholder="Enter quantity" min="1" required>
            
            <label for="expiry_date">Expiry Date:</label>
            <input type="date" id="expiry_date" name="expiry_date" required>

            <button type="submit">Add Food</button>
        </form>
    </div>

    <!-- Layout chat ai -->
    @include('layouts.chat')

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
