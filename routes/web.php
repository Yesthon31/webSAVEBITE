<?php

use App\Http\Controllers\GolangApiController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

// Public routes
Route::get('/', function () {
    return view('firstpage');
});

Route::get('/login', [GolangApiController::class, 'showLoginForm'])->name('login');
Route::post('/login', [GolangApiController::class, 'login']);
Route::get('/register', [GolangApiController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [GolangApiController::class, 'register']);

// Protected routes
Route::middleware(['web'])->group(function () {
    // User routes
    Route::post('/logout', [GolangApiController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [GolangApiController::class, 'dashboard']);
    Route::get('/foods', [GolangApiController::class, 'getFoods']);
    Route::get('/foods-calender', [GolangApiController::class, 'getFoodsCalendarApi']);
    Route::get('/foods/add', [GolangApiController::class, 'showAddFoodForm']);
    Route::post('/foods', [GolangApiController::class, 'addFood']);
    Route::delete('/foods/{id}', [GolangApiController::class, 'deleteFood'])->name('foods.delete');
    Route::get('/recipes', [GolangApiController::class, 'getRecipes']);
    Route::post('/recipe', [GolangApiController::class, 'addRecipe']);
    Route::delete('/recipes/{id}', [GolangApiController::class, 'deleteRecipe'])->name('recipes.delete');
    Route::get('/user', [GolangApiController::class, 'getUser']);

    // Admin routes
    Route::prefix('admin')->group(function () {
        Route::middleware(\App\Http\Middleware\AdminAuth::class)->group(function () {
        Route::get('/dashboard', [GolangApiController::class, 'activityLogs']);
                
            Route::middleware([\App\Http\Middleware\CheckPermission::class.':view_food'])->group(function () {
                Route::get('/foods', [GolangApiController::class, 'getAdminFoods']);
                Route::get('/foods/add', [GolangApiController::class, 'showAddFoodForm']);
                Route::post('/foods', [GolangApiController::class, 'addFood']);
                Route::delete('/foods/{id}', [GolangApiController::class, 'deleteFood'])->name('admin.foods.delete');
            });
            
            Route::middleware([\App\Http\Middleware\CheckPermission::class.':view_recipes'])->group(function () {
                Route::get('/recipes', [GolangApiController::class, 'getAdminRecipes']);
            });
            
            Route::middleware([\App\Http\Middleware\CheckPermission::class.':view_users'])->group(function () {
                Route::get('/users', [GolangApiController::class, 'getUsers']);
            });
            
            Route::middleware([\App\Http\Middleware\CheckPermission::class.':view_login_logs'])->group(function () {
                Route::get('/logs', [GolangApiController::class, 'getAdminLogs']);
            });
            
            // Category management
            Route::middleware([\App\Http\Middleware\CheckPermission::class.':manage_categories'])->group(function () {
                Route::get('/categories', [GolangApiController::class, 'getCategories']);
                Route::delete('/category/{id}', [GolangApiController::class, 'deleteCategory']);
                Route::post('/category', [GolangApiController::class, 'addCategory']);
            });
            
            // User management
            Route::middleware([\App\Http\Middleware\CheckPermission::class.':promote_user_to_role'])->group(function () {
                Route::get('/users/{id}/promote', [GolangApiController::class, 'showPromoteForm']);
                Route::post('/promote', [GolangApiController::class, 'promoteUser']);
            });
            
            Route::middleware([\App\Http\Middleware\CheckPermission::class.':delete_user'])->group(function () {
                Route::delete('/users/{id}', [GolangApiController::class, 'deleteUser']);
            });
        });

        // Super Admin routes
        Route::middleware(\App\Http\Middleware\SuperAdminAuth::class)->group(function () {
            Route::get('/super/users', [GolangApiController::class, 'getUsers']);
            Route::delete('/super/users/{id}', [GolangApiController::class, 'deleteUser']);
            Route::post('/super/promote', [GolangApiController::class, 'promoteUser']);
        });
    });

    // Login logs route
    Route::middleware([\App\Http\Middleware\CheckPermission::class.':view_login_logs'])->group(function () {
        Route::get('/login-logs', [GolangApiController::class, 'getLoginLogs'])->name('loginlogs.index');
    });

    Route::post('/api/chat', [GolangApiController::class, 'chat'])->name('api.chat');
});






