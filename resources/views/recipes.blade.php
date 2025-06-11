<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe List</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
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
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        header {
            background: var(--white);
            color: var(--text-dark);
            text-align: center;
            padding: 2rem 1rem;
            box-shadow: 0 4px 15px rgba(76, 175, 80, 0.1);
        }

        header h1 {
            font-size: 2.2em;
            margin: 0;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        header h1 i {
            color: var(--primary-green);
        }

        header .subtitle {
            color: #666;
            margin-top: 0.5rem;
            font-size: 1.1em;
        }

        .container {
            max-width: 900px;
            margin: 2rem auto;
            padding: 0 1rem;
            flex: 1;
        }

        .recipe-card {
            background: var(--white);
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(76, 175, 80, 0.1);
            margin: 1.5rem 0;
            padding: 1.5rem;
            transition: all 0.3s ease;
            border: 1px solid #e0e0e0;
        }

        .recipe-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(76, 175, 80, 0.15);
        }

        .recipe-title {
            font-size: 1.3em;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .recipe-title i {
            color: var(--primary-green);
        }

        .recipe-content {
            color: #666;
            line-height: 1.6;
            font-size: 1em;
            white-space: pre-line;
        }

        .action-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 2rem;
            gap: 1rem;
        }

        .btn {
            background: var(--primary-green);
            color: var(--white);
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1em;
            font-weight: 500;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .btn:hover {
            background: var(--light-green);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(76, 175, 80, 0.2);
        }

        .btn-delete {
            background: #f44336;
        }

        .btn-delete:hover {
            background: #d32f2f;
        }

        .empty-message {
            text-align: center;
            color: #666;
            font-size: 1.1em;
            margin: 3rem 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        }

        .empty-message i {
            font-size: 2em;
            color: var(--primary-green);
        }

        @media (max-width: 768px) {
            .container {
                margin: 1rem;
            }

            header {
                padding: 1.5rem 1rem;
            }

            header h1 {
                font-size: 1.8em;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>
            <i class="fas fa-book-open"></i>
            Recipe List
        </h1>
        <div class="subtitle">Collection of your favorite recipes</div>
    </header>

    <div class="container">
        @if(session('error'))
            <div style="background: #ffebee; color: #f44336; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                {{ session('error') }}
            </div>
        @endif

        @if(!empty($recipes))
            @foreach($recipes as $recipe)
                <div class="recipe-card">
                    <div class="recipe-title">
                        <i class="fas fa-utensils"></i>
                        {{ $recipe['title'] ?? 'Recipe' }}
                    </div>
                    <div class="recipe-content">
                        <?php
                            $cleanedRecipe = $recipe['recipe'];
                            // Remove bold/italic markers (**)
                            $cleanedRecipe = str_replace('**', '', $cleanedRecipe);
                            // Remove header markers (#)
                            $cleanedRecipe = preg_replace('/^#+\s*/m', '', $cleanedRecipe);
                            // Remove list item markers (* followed by a space at the beginning of a line)
                            $cleanedRecipe = preg_replace('/^\*\s*/m', '', $cleanedRecipe);
                        ?>
                        {!! nl2br(e($cleanedRecipe)) !!}
                    </div>
                    <form action="https://web-production-56c4.up.railway.app/recipes/{{ $recipe['id'] }}" method="POST" style="margin-top: 1rem;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-delete">
                            <i class="fas fa-trash"></i> Delete Recipe
                        </button>
                    </form>
                </div>
            @endforeach
        @else
            <div class="empty-message">
                <i class="fas fa-clipboard-list"></i>
                <p>No recipes available yet.</p>
            </div>
        @endif

        <div class="action-buttons">
            <a href="{{ url('/dashboard') }}" class="btn">
                <i class="fas fa-home"></i> Dashboard
            </a>
            <a href="{{ url('/foods') }}" class="btn">
                <i class="fas fa-arrow-left"></i> Back to Foods
            </a>
        </div>
    </div>
</body>
</html>
