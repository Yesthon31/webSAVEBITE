<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Foods</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="https://unpkg.com/@dotlottie/player-component@2.7.12/dist/dotlottie-player.mjs" type="module"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="icon" href="/images/logoSaveBite.png">
    <style>
        :root {
            --primary-green: #4b6930;
            --light-green: #6b904c;
            --accent-yellow: #FDB813;
            --white: #ffffff;
            --gray-bg: #f8f9fa;
            --text-dark: #2c3e50;
            --danger: #e74c3c;
            --warning: #f39c12;
            --card-shadow: 0 8px 25px rgba(75, 105, 48, 0.1);
            --hover-shadow: 0 12px 30px rgba(75, 105, 48, 0.15);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--gray-bg);
            color: var(--text-dark);
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

        h1 {
            text-align: center;
            color: var(--text-dark);
            margin: 10px auto 0;
            font-size: 2.2em;
            font-weight: 600;
            position: relative;
            padding-bottom: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1;
        }

        .title-animation {
            width: 250px;
            height: 250px;
            margin: 0 auto;
            display: block;
            pointer-events: none;
        }

        .container {
            max-width: 1000px;
            margin: 10px auto;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.8));
            border-radius: 15px;
            box-shadow: var(--card-shadow);
            padding: 2rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(75, 105, 48, 0.1);
        }

        ul {
            padding: 0;
            list-style-type: none;
            margin: 0;
        }

        li {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95), rgba(255, 255, 255, 0.9));
            padding: 1.2rem;
            border-radius: 12px;
            margin-bottom: 1rem;
            box-shadow: 0 4px 15px rgba(75, 105, 48, 0.08);
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s ease;
            border: 1px solid rgba(75, 105, 48, 0.1);
        }

        li:hover {
            transform: translateY(-2px);
            box-shadow: var(--hover-shadow);
            border-color: var(--primary-green);
        }

        .food-info {
            display: flex;
            flex-direction: column;
            gap: 8px;
            flex: 1;
        }

        .food-title {
            font-weight: 600;
            font-size: 1.1em;
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--primary-green);
        }

        .food-expiry, .food-status, .food-quantity, .food-category {
            font-size: 0.95em;
            color: #546e7a;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .food-status {
            font-weight: 500;
        }

        .actions {
            display: flex;
            gap: 10px;
        }

        button[type="submit"] {
            background: linear-gradient(135deg, var(--primary-green), var(--light-green));
            color: var(--white);
            padding: 12px 24px;
            font-size: 1.1em;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
            width: auto;
            min-width: 200px;
            box-shadow: 0 4px 15px rgba(75, 105, 48, 0.2);
        }

        button[type="submit"]:hover {
            background: linear-gradient(135deg, var(--light-green), var(--primary-green));
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(75, 105, 48, 0.3);
        }

        .delete-button {
            padding: 8px 16px;
            background: linear-gradient(135deg, var(--danger), #c0392b);
            color: var(--white);
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1em;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(231, 76, 60, 0.2);
        }

        .delete-button:hover {
            background: linear-gradient(135deg, #c0392b, var(--danger));
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(231, 76, 60, 0.3);
        }

        .recipe-content {
            background: linear-gradient(135deg, #e8f5e9, #f1f8e9);
            border-radius: 12px;
            padding: 1.2rem;
            margin-top: 1rem;
            font-size: 1em;
            color: var(--text-dark);
            border: 1px solid var(--light-green);
            box-shadow: 0 4px 15px rgba(75, 105, 48, 0.1);
        }

        .loading-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding: 1rem;
        }

        .loading-text {
            color: var(--primary-green);
            font-size: 1.2em;
            margin-top: 1rem;
            font-weight: 500;
        }

        .back-button {
            position: absolute;
            top: 20px;
            left: 20px;
            background: linear-gradient(135deg, var(--primary-green), var(--light-green));
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
            z-index: 1000;
            box-shadow: 0 4px 15px rgba(75, 105, 48, 0.2);
        }

        .back-button:hover {
            background: linear-gradient(135deg, var(--light-green), var(--primary-green));
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(75, 105, 48, 0.3);
        }

        .recipe-quantity {
            background: linear-gradient(135deg, #f8f9fa, #f5f6f7);
            padding: 12px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 8px;
            border: 1px solid rgba(75, 105, 48, 0.1);
        }

        .recipe-quantity label {
            font-size: 0.9em;
            color: var(--text-dark);
            font-weight: 500;
        }

        .quantity-input {
            padding: 8px 12px;
            border: 1px solid var(--light-green);
            border-radius: 6px;
            font-size: 0.9em;
            color: var(--text-dark);
            width: 80px;
            transition: all 0.3s ease;
        }

        .quantity-input:focus {
            border-color: var(--primary-green);
            box-shadow: 0 0 0 3px rgba(75, 105, 48, 0.1);
            outline: none;
        }

        /* Delete Confirmation Modal Styles */
        #delete-confirmation {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1100;
            backdrop-filter: blur(5px);
        }

        .delete-card {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            width: 90%;
            max-width: 400px;
            text-align: center;
        }

        .delete-card-content {
            margin-bottom: 1.5rem;
        }

        .delete-card-content p {
            color: var(--text-dark);
            font-size: 1.1rem;
            margin-bottom: 1.5rem;
        }

        .delete-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
        }

        .delete-confirm-button {
            background: linear-gradient(135deg, var(--danger), #c0392b);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .delete-confirm-button:hover {
            background: linear-gradient(135deg, #c0392b, var(--danger));
            transform: translateY(-2px);
        }

        .delete-cancel-button {
            background: #95a5a6;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .delete-cancel-button:hover {
            background: #7f8c8d;
            transform: translateY(-2px);
        }

        .loading {
            text-align: center;
            padding: 1rem;
            color: var(--text-dark);
        }

        .success-message {
            color: var(--primary-green);
            text-align: center;
            padding: 1rem;
        }

        @media (max-width: 768px) {
            .container {
                margin: 20px;
                padding: 1rem;
            }

            h1 {
                font-size: 1.8em;
                margin-top: 30px;
            }

            li {
                flex-direction: column;
                gap: 1rem;
            }

            .actions {
                width: 100%;
                justify-content: flex-end;
            }

            button[type="submit"] {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <a href="/dashboard" class="back-button">
        <i class="fas fa-arrow-left"></i> Back
    </a>

    <!-- Add Delete Confirmation Modal -->
    <div id="delete-confirmation">
        <div class="delete-card">
            <div class="delete-card-content">
                <p>Are you sure you want to delete this food item?</p>
                <div class="delete-buttons">
                    <button class="delete-confirm-button" onclick="confirmDelete()">Delete</button>
                    <button class="delete-cancel-button" onclick="cancelDelete()">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <h1>
        <dotlottie-player 
            src="https://lottie.host/22cccf33-a712-4286-a29f-3335cf8bc871/cRpmVMcwHq.lottie" 
            background="transparent" 
            speed="1" 
            class="title-animation"
            loop 
            autoplay
        ></dotlottie-player>
    </h1>

    <div class="container" data-aos="fade-up">
        @if(session('error'))
            <div style="background: #ffebee; color: var(--danger); padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div style="background: #e8f5e9; color: var(--primary-green); padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                {{ session('success') }}
            </div>
        @endif

        @if(empty($foods))
            <p style="text-align: center; font-size: 1.1em; color: #666; margin: 2rem 0;">
                No foods available. Please add some food items.
            </p>
        @else
            <form id="recipeForm">
                <ul>
                    @foreach($foods as $food)
                        <li data-aos="fade-up">
                            <div class="food-info">
                                <span class="food-title">
                                    <input type="checkbox" class="food-checkbox" data-food-id="{{ $food['id'] }}" data-food-stock="{{ $food['quantity'] ?? 0 }}">
                                    {{ $food['icon'] }} {{ $food['name'] }}
                                </span>
                                <span class="food-expiry">
                                    <i class="fas fa-calendar"></i> Expiry: {{ $food['expiry_date'] }}
                                </span>
                                <span class="food-status">
                                    <i class="fas fa-info-circle"></i> Status: {{ ucfirst($food['status']) }}
                                </span>
                                <span class="food-quantity">
                                    <i class="fas fa-box"></i> Quantity: {{ $food['quantity'] ?? 0 }}
                                </span>
                                <span class="food-category">
                                    <i class="fas fa-tag"></i> Category: {{ $food['category_name'] ?? 'Uncategorized' }}
                                </span>
                                <div class="recipe-quantity" style="display: none;">
                                    <label>Use quantity:</label>
                                    <input type="number" class="quantity-input" min="1" max="{{ $food['quantity'] ?? 0 }}" value="1">
                                </div>
                            </div>
                            <div class="actions">
                                <button type="button" class="delete-button" onclick="deleteFood({{ $food['id'] }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <button type="submit">Generate Recipes</button>
            </form>
        @endif
        <div id="recipe-result" class="recipe-content" style="display: none;"></div>
    </div>

    <script>
    AOS.init();
    $(document).ready(function() {
        // Show/hide quantity input when checkbox is checked/unchecked
        $('.food-checkbox').change(function() {
            var quantityDiv = $(this).closest('.food-info').find('.recipe-quantity');
            if ($(this).is(':checked')) {
                quantityDiv.slideDown();
            } else {
                quantityDiv.slideUp();
            }
        });

        $('#recipeForm').submit(function(event) {
            event.preventDefault();
            var ingredients = [];
            $('.food-checkbox:checked').each(function() {
                var foodId = $(this).data('food-id');
                var quantity = $(this).closest('.food-info').find('.quantity-input').val();
                var maxStock = $(this).data('food-stock');
                
                // Validate quantity
                if (quantity > maxStock) {
                    alert("Quantity cannot exceed available stock!");
                    return;
                }
                
                ingredients.push({
                    id: foodId,
                    quantity: parseInt(quantity)
                });
            });

            if (ingredients.length === 0) {
                alert("Please select at least one food item.");
                return;
            }

            $('button[type="submit"]').text('Loading...').attr('disabled', true);
            $('#recipe-result').html(`
                <div class="loading-container">
                    <dotlottie-player 
                        src="https://lottie.host/69eb0b46-8c00-4c31-a73b-46de157dae20/UqRgy32puP.lottie" 
                        background="transparent" 
                        speed="1" 
                        style="width: 300px; height: 300px" 
                        loop 
                        autoplay
                    ></dotlottie-player>
                    <div class="loading-text">Generating your recipe...</div>
                </div>
            `).fadeIn();

            $.ajax({
                url: '/recipe',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                data: JSON.stringify({
                    ingredients: ingredients
                }),
                success: function(response) {
                    console.log('Response:', response); // Debug log
                    var recipeContent = $('#recipe-result');
                    if (response && response.recipe) {
                        var formattedRecipe = response.recipe.replace(/\n/g, '<br>');
                        recipeContent.html(formattedRecipe).fadeIn();
                    } else {
                        recipeContent.html('<p>No recipe generated. Please try again.</p>').fadeIn();
                    }
                    $('button[type="submit"]').text('Generate Recipes').attr('disabled', false);
                },
                error: function(xhr, status, error) {
                    console.error('Error details:', {
                        status: status,
                        error: error,
                        response: xhr.responseText
                    });
                    var errorMessage = "An error occurred while generating the recipes.";
                    if (xhr.responseJSON && xhr.responseJSON.error) {
                        errorMessage = xhr.responseJSON.error;
                    }
                    alert(errorMessage);
                    $('button[type="submit"]').text('Generate Recipes').attr('disabled', false);
                }
            });
        });
    });
    let foodToDelete = null;
    function deleteFood(foodId) {
        foodToDelete = foodId;
        document.getElementById('delete-confirmation').style.display = 'block';
    }
    function confirmDelete() {
        $('#delete-confirmation').html('<div class="loading">Deleting...</div>');
        if (foodToDelete !== null) {
            $.ajax({
                url: '/foods/' + foodToDelete,
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#delete-confirmation').html('<div class="success-message">Food deleted successfully!</div>');
                    setTimeout(function() {
                        location.reload();
                    }, 1200);
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                    $('#delete-confirmation').html('<div class="delete-card-content"><p>An error occurred!</p><button class="delete-cancel-button" onclick="cancelDelete()">Close</button></div>');
                }
            });
        }
    }
    function cancelDelete() {
        document.getElementById('delete-confirmation').style.display = 'none';
    }
    </script>
</body>
</html>
