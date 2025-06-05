<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class GolangApiController extends Controller
{
    private $api = 'https://golangtes-production.up.railway.app';
    private $publicMethods = [
        'showLoginForm',
        'login',
        'showRegisterForm',
        'register'
    ];

    protected function checkToken()
    {
        $currentMethod = debug_backtrace()[1]['function'];
        
        if (!in_array($currentMethod, $this->publicMethods) && !Session::has('token')) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu');
        }
        
        return null;
    }

    public function showRegisterForm()
    {
     
        try {
            $response = Http::get($this->api.'/roles');
            $roles = $response->successful() ? $response->json()['roles'] : ['user'];
        } catch (\Exception $e) {
            $roles = ['user'];
        }
        
        return view('register', ['roles' => $roles]);
    }

    public function activityLogs()
    {
        $token = Session::get('token');
        
        if (!$token) {
            return redirect('/login');
        }

        $data = [
            'userCount' => 0,
            'todayLogins' => 0,
            'failedLogins' => 0,
            'categories' => [],
            'loginActivity' => null
        ];

     
        $role = Session::get('role');
        $roleId = Session::get('role_id', 5);

       
        if ($role === 'super_admin' || $role === 'admin_user') {
            $responseUsers = Http::withToken($token)->get($this->api . '/users');
            if ($responseUsers->successful()) {
                $users = $responseUsers->json()['users'] ?? [];
                $data['userCount'] = count($users);
            }

        
            $responseLogs = Http::withToken($token)->get($this->api . '/admin/logs');
            if ($responseLogs->successful()) {
                $loginLogs = $responseLogs->json() ?? [];
                
            
                $today = now()->setTimezone('Asia/Jakarta')->startOfDay();
                foreach ($loginLogs as $log) {
                    $logDate = Carbon::parse($log['login_time'])->setTimezone('Asia/Jakarta');
                    if ($logDate->startOfDay()->eq($today)) {
                        $data['todayLogins']++;
                    }
                    if (isset($log['status']) && $log['status'] === 'failed') {
                        $data['failedLogins']++;
                    }
                }

                // Process weekly login activity
                $daysOfWeek = [];
                $sortedLogins = array_fill(0, 7, 0);
                
                for ($i = 6; $i >= 0; $i--) {
                    $date = now()->setTimezone('Asia/Jakarta')->subDays($i);
                    $daysOfWeek[] = $date->format('D');
                    $targetDate = $date->startOfDay();
                    
                    foreach ($loginLogs as $log) {
                        $logDate = Carbon::parse($log['login_time'])->setTimezone('Asia/Jakarta');
                        if ($logDate->startOfDay()->eq($targetDate)) {
                            $sortedLogins[6 - $i]++;
                        }
                    }
                }

                $data['loginActivity'] = [
                    'dates' => $daysOfWeek,
                    'logins' => $sortedLogins,
                ];

                // Debug log untuk memastikan data
                \Illuminate\Support\Facades\Log::info('Login Statistics:', [
                    'today' => $today->toDateTimeString(),
                    'todayLogins' => $data['todayLogins'],
                    'weeklyLogins' => $sortedLogins,
                    'sample_log_date' => isset($loginLogs[0]) ? Carbon::parse($loginLogs[0]['login_time'])->setTimezone('Asia/Jakarta')->toDateTimeString() : null
                ]);
            }
        }

        // Get categories for admin_inventori and admin_resep
        if (in_array($role, ['super_admin', 'admin_inventori', 'admin_resep'])) {
            try {
                $responseCategories = Http::withToken($token)->get($this->api . '/categories');
                if ($responseCategories->successful()) {
                    $data['categories'] = $responseCategories->json();
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Error fetching categories:', ['error' => $e->getMessage()]);
            }
        }

        return view('admin.admin-dashboard', $data);
    }

    public function register(Request $r)
    {
        // Validasi input
        $r->validate([
            'username' => 'required|min:3',
            'email' => 'required|email',
            'password' => 'required|min:8'
        ], [
            'username.required' => 'Username harus diisi',
            'username.min' => 'Username minimal 3 karakter',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 8 karakter'
        ]);

        // Cek format email dan password sesuai aturan Go
        if (!preg_match('/^[\w._%+\-]+@[\w.\-]+\.[A-Za-z]{2,}$/', $r->email)) {
            return back()->with('error', 'Format email tidak valid');
        }

        if (!preg_match('/^(?=.*[A-Z])(?=.*[!@#$%^&*()_+{}[\]:;<>,.?\/~`\-=]).{8,}$/', $r->password)) {
            return back()->with('error', 'Password harus minimal 8 karakter, memiliki huruf besar dan simbol');
        }

        $data = [
            'username' => $r->username,
            'password' => $r->password,
            'email' => $r->email,
            'role' => 'user'  
        ];

        try {
            $response = Http::post($this->api.'/register', $data);
            
            if ($response->successful()) {
                return redirect('/login')->with('success', 'Berhasil daftar, silakan login');
            }

            $error = $response->json()['error'] ?? 'Gagal mendaftar';
            return back()->with('error', $error)->withInput($r->except('password'));
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput($r->except('password'));
        }
    }

    public function showLoginForm()
    {
        if (Session::has('token')) {
            $roleId = Session::get('role_id', 5);
            return redirect($roleId <= 4 ? '/admin/dashboard' : '/dashboard');
        }
        return view('login');
    }

    public function login(Request $r)
    {
        // Validasi input
        $r->validate([
            'username' => 'required',
            'password' => 'required'
        ], [
            'username.required' => 'Username harus diisi',
            'password.required' => 'Password harus diisi'
        ]);

        try {
            $response = Http::post($this->api.'/login', [
                'username' => $r->username,
                'password' => $r->password
            ]);
            
            $responseData = $response->json();

            if ($response->successful() && isset($responseData['token'])) {
                $role = $responseData['role'] ?? 'user';
                
                // Tentukan role_id berdasarkan string role
                $roleId = 5; // default user
                switch($role) {
                    case 'super_admin':
                        $roleId = 1;
                        break;
                    case 'admin_inventori':
                        $roleId = 2;
                        break;
                    case 'admin_resep':
                        $roleId = 3;
                        break;
                    case 'admin_user':
                        $roleId = 4;
                        break;
                }

           
                Session::put('token', $responseData['token']);
                Session::put('role_id', $roleId);
                Session::put('role', $role);
                Session::put('username', $r->username);
                Session::put('user_id', $responseData['user_id'] ?? null);

          
                if ($roleId <= 4) { 
                    return redirect('/admin/dashboard')
                        ->with('success', 'Selamat datang kembali, Admin ' . $r->username);
                }
                
                return redirect('/dashboard')
                    ->with('success', 'Selamat datang kembali, ' . $r->username);
            }

            $error = $responseData['error'] ?? 'Username atau password salah';
            return back()->with('error', $error)->withInput($r->except('password'));
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput($r->except('password'));
        }
    }

    public function logout()
    {
        Session::forget(['token', 'role', 'username']);
        return redirect('/login')->with('success', 'Berhasil logout');
    }

    public function adminDashboard()
    {
        return view('admin.admin-dashboard'); 
    }

    public function dashboard()
    {
        if ($response = $this->checkToken()) return $response;
        
        $token = Session::get('token');
        $response = Http::withToken($token)->get($this->api.'/foods');
        $foods = $response->successful() ? $response->json() : [];

        return view('dashboard', ['foods' => $foods]);
    }

    public function getFoods()
    {
        if ($response = $this->checkToken()) return $response;
        
        $token = Session::get('token');
        
        // Build query parameters for filtering
        $queryParams = [];
        
        if (request('category')) {
            $queryParams['category_id'] = request('category');
        }
        
        if (request('owner')) {
            $queryParams['owner'] = request('owner');
        }
        
        if (request('expiry_from')) {
            $queryParams['expiry_from'] = request('expiry_from');
        }
        
        if (request('expiry_to')) {
            $queryParams['expiry_to'] = request('expiry_to');
        }
        
        // Get foods with filters
        $response = Http::withToken($token)
            ->get($this->api.'/foods', $queryParams);
        
        $foods = $response->successful() ? $response->json() : [];

        if (!is_array($foods)) {
            $foods = [];
        }

        // Get categories for filter dropdown
        $categoriesResponse = Http::withToken($token)->get($this->api.'/categories');
        $categories = $categoriesResponse->successful() ? $categoriesResponse->json() : [];

        $foods = collect($foods)->map(function ($food) {
            $expiry = Carbon::parse($food['expiry_date']);
            $today = Carbon::today();
            $diffInDays = $today->diffInDays($expiry, false);

            if($diffInDays < 0) {
                $food['status'] = 'expired';
                $food['color'] = 'red';
                $food['icon'] = '❌';
            } elseif($diffInDays < 14) {
                $food['status'] = 'warning';
                $food['color'] = 'orange';
                $food['icon'] = '⚠️';
            } else {
                $food['status'] = 'safe';
                $food['color'] = 'green';
                $food['icon'] = '✅';
            }

            return $food;
        })
        ->sortBy(function ($food) {
            $iconOrder = ['❌' => 0, '⚠️' => 1, '✅' => 2];
            return $iconOrder[$food['icon']] ?? 3;
        })
        ->values();

        return view('foods', [
            'foods' => $foods,
            'categories' => $categories
        ]);
    }

    public function getFoodsCalendarApi()
    {
        $token = Session::get('token');
        if (!$token) {
            return response()->json([]);
        }

        $response = Http::withToken($token)->get($this->api . '/foods');
        $foods = $response->successful() ? $response->json() : [];

        $now = now();

        $foods = collect($foods)->map(function ($food) use ($now) {
            $expiry = \Carbon\Carbon::parse($food['expiry_date']);
            $diffDays = $expiry->diffInDays($now, false); 

            $food['is_near_expired'] = $diffDays <= 14 && $diffDays >= 0;
            $food['is_expired'] = $diffDays < 0;

            return $food;
        });

        return response()->json($foods);
    }

    public function getFoodCategories()
    {
        if ($response = $this->checkToken()) return $response;
        
        $token = Session::get('token');
        try {
            $response = Http::withToken($token)->get($this->api . '/categories');
            if ($response->successful()) {
                return $response->json();
            }
            
            // Fallback to static data if API fails
            return [
                ['id' => 1, 'name' => 'Buah-buahan'],
                ['id' => 2, 'name' => 'Sayuran'],
                ['id' => 3, 'name' => 'Daging'],
                ['id' => 4, 'name' => 'Makanan Laut'],
                ['id' => 5, 'name' => 'Makanan Olahan'],
                ['id' => 6, 'name' => 'Minuman'],
                ['id' => 7, 'name' => 'Bumbu Dapur'],
                ['id' => 8, 'name' => 'Makanan Kering'],
                ['id' => 9, 'name' => 'Makanan Beku'],
                ['id' => 10, 'name' => 'Lainnya']
            ];
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error fetching categories:', ['error' => $e->getMessage()]);
            // Return static data as fallback
            return [
                ['id' => 1, 'name' => 'Buah-buahan'],
                ['id' => 2, 'name' => 'Sayuran'],
                ['id' => 3, 'name' => 'Daging'],
                ['id' => 4, 'name' => 'Makanan Laut'],
                ['id' => 5, 'name' => 'Makanan Olahan'],
                ['id' => 6, 'name' => 'Minuman'],
                ['id' => 7, 'name' => 'Bumbu Dapur'],
                ['id' => 8, 'name' => 'Makanan Kering'],
                ['id' => 9, 'name' => 'Makanan Beku'],
                ['id' => 10, 'name' => 'Lainnya']
            ];
        }
    }

    public function showAddFoodForm()
    {
        if ($response = $this->checkToken()) return $response;

        $categories = $this->getFoodCategories();
        return view('foodsadd', ['categories' => $categories]);
    }

    public function addFood(Request $r)
    {
        if ($response = $this->checkToken()) return $response;

        // Validasi input
        $r->validate([
            'name' => 'required|string|min:3',
            'expiry_date' => 'required|date|after:today',
            'quantity' => 'required|integer|min:1',
            'category_id' => 'required|integer'
        ], [
            'name.required' => 'Nama makanan harus diisi',
            'name.min' => 'Nama makanan minimal 3 karakter',
            'expiry_date.required' => 'Tanggal kadaluarsa harus diisi',
            'expiry_date.date' => 'Format tanggal tidak valid',
            'expiry_date.after' => 'Tanggal kadaluarsa harus lebih dari hari ini',
            'quantity.required' => 'Jumlah harus diisi',
            'quantity.integer' => 'Jumlah harus berupa angka',
            'quantity.min' => 'Jumlah minimal 1',
            'category_id.required' => 'Kategori harus dipilih',
            'category_id.integer' => 'Kategori tidak valid'
        ]);

        $token = Session::get('token');

        try {
            $response = Http::withToken($token)->post($this->api.'/foods', [
                'name' => $r->name,
                'expiry_date' => $r->expiry_date,
                'quantity' => (int)$r->quantity,
                'category_id' => (int)$r->category_id
            ]);

            if ($response->successful()) {
                return redirect('/foods')->with('success', 'Makanan berhasil ditambahkan');
            }

            $error = $response->json()['error'] ?? 'Gagal menambah makanan';
            return back()->with('error', $error)->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function getUser()
    {
        $token = Session::get('token');

        if (!$token) {
            return redirect('/login');
        }

        $response = Http::withToken($token)->get($this->api.'/users');  

        if ($response->successful()) {
            $users = $response->json()['users'];  
            return view('admin.users', ['users' => $users]);
        }

        return back()->with('error', 'Gagal mengambil data users');
    }

    public function deleteFood($id)
    {
        $token = Session::get('token');

        if (!$token) {
            return redirect('/login');
        }

        $response = Http::withToken($token)->delete($this->api.'/foods/'.$id);

        if ($response->successful()) {
            return redirect('/foods');
        }

        return back()->with('error', 'Gagal menghapus makanan');
    }

    public function deleteRecipe($id)
    {
        $token = Session::get('token');

        if (!$token) {
            return redirect('/login');
        }

        $response = Http::withToken($token)->delete($this->api . '/recipes/' . $id);

        if ($response->successful()) {
            return redirect('/recipes');
        }

        return back()->with('error', 'Gagal menghapus resep');
    }

    public function getLoginLogs()
    {
        $token = Session::get('token');
        if (!$token) {
            return redirect('/login');
        }

        $response = Http::withToken($token)->get($this->api.'/admin/logs');
        if ($response->successful()) {
            $loginLogs = $response->json() ?? [];
            if (!is_array($loginLogs)) {
                $loginLogs = [$loginLogs];
            }
            return view('login-logs', ['loginLogs' => $loginLogs]);
        }

        return back()->with('error', 'Gagal mengambil log login');
    }

    public function addLoginLog(Request $request)
    {
        $token = Session::get('token');
        if (!$token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            $response = Http::withToken($token)->post($this->api.'/login-logs', [
                'username' => $request->username,
                'ip_address' => $request->ip()
            ]);

            if ($response->successful()) {
                return response()->json(['message' => 'Login log berhasil ditambahkan']);
            }

            return response()->json(['error' => 'Gagal menambahkan login log'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function getRecipes()
    {
        $token = Session::get('token');
        if (!$token) {
            return redirect('/login');
        }

        $response = Http::withToken($token)->get($this->api.'/recipes');
        if ($response->successful()) {
            $recipes = $response->json() ?? [];
            return view('recipes', ['recipes' => $recipes]);
        }

        return back()->with('error', 'Gagal mengambil resep');
    }

    public function addRecipe(Request $r)
    {
        $token = Session::get('token');
        if (!$token) {
            return response()->json(['error' => 'Token tidak valid'], 401);
        }

        try {
            // Validate request format
            if (!$r->has('ingredients') || !is_array($r->ingredients)) {
                return response()->json(['error' => 'Format request tidak valid'], 400);
            }

            // Log the incoming request for debugging
            \Illuminate\Support\Facades\Log::info('Recipe request:', [
                'ingredients' => $r->ingredients
            ]);

            $response = Http::withToken($token)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json'
                ])
                ->post($this->api.'/recipe', [
                    'ingredients' => $r->ingredients
                ]);

            // Log the API response for debugging
            \Illuminate\Support\Facades\Log::info('Recipe API response:', [
                'status' => $response->status(),
                'body' => $response->json()
            ]);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['recipe'])) {
                    return response()->json(['recipe' => $data['recipe']], 200);
                }
                return response()->json(['error' => 'Format response tidak valid'], 500);
            }

            $error = $response->json()['error'] ?? 'Gagal membuat resep';
            return response()->json(['error' => $error], $response->status());
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Recipe error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function getAdminFoods()
    {
        $token = Session::get('token');
        if (!$token) {
            return redirect('/login');
        }

        $response = Http::withToken($token)->get($this->api.'/admin/foods');
        
        if ($response->successful()) {
            $foods = $response->json();
            
            if (!is_array($foods)) {
                $foods = [];
            }

            // Process and filter foods
            $foods = collect($foods)->map(function ($food) {
                // Map API fields to view fields
                $mappedFood = [
                    'id' => $food['id'] ?? 0,
                    'name' => $food['name'] ?? 'Unnamed',
                    'quantity' => $food['quantity'] ?? 0,
                    'expiry_date' => $food['expiryDate'] ?? null,
                    'owner' => $food['user'] ?? null,
                    'category_name' => $food['category'] ?? null,
                    'category' => $food['category'] ?? null,
                    'status' => 'unknown',
                    'color' => 'gray',
                    'icon' => '❓'
                ];

                // Calculate status based on expiry date
                if (!empty($mappedFood['expiry_date'])) {
                    try {
                        $expiry = Carbon::parse($mappedFood['expiry_date']);
                        $today = Carbon::today();
                        $diffInDays = $today->diffInDays($expiry, false);

                        if($diffInDays < 0) {
                            $mappedFood['status'] = 'expired';
                            $mappedFood['color'] = 'red';
                            $mappedFood['icon'] = '❌';
                        } elseif($diffInDays < 14) {
                            $mappedFood['status'] = 'warning';
                            $mappedFood['color'] = 'orange';
                            $mappedFood['icon'] = '⚠️';
                        } else {
                            $mappedFood['status'] = 'safe';
                            $mappedFood['color'] = 'green';
                            $mappedFood['icon'] = '✅';
                        }
                    } catch (\Exception $e) {
                        \Illuminate\Support\Facades\Log::error('Error processing food expiry date:', [
                            'food' => $mappedFood,
                            'error' => $e->getMessage()
                        ]);
                    }
                }

                return $mappedFood;
            });

            // Get unique owners for filter dropdown
            $owners = $foods->pluck('owner')->filter()->unique()->values()->all();

            // Get categories for mapping ID to name
            $categoriesResponse = Http::withToken($token)->get($this->api.'/categories');
            $categories = $categoriesResponse->successful() ? $categoriesResponse->json() : [];
            $categoryMap = collect($categories)->pluck('name', 'id')->all();

            // Apply filters only if specific values are selected
            $selectedCategory = request('category');
            $selectedStatus = request('status');
            $selectedOwner = request('owner');
            $searchQuery = request('search');

            // Filter by name if search query exists
            if (!empty($searchQuery)) {
                $foods = $foods->filter(function ($food) use ($searchQuery) {
                    return stripos($food['name'], $searchQuery) !== false;
                });
            }

            if (!empty($selectedCategory)) {
                $categoryName = $categoryMap[$selectedCategory] ?? null;
                if ($categoryName) {
                    $foods = $foods->filter(function ($food) use ($categoryName) {
                        return strtolower($food['category']) === strtolower($categoryName);
                    });
                }
            }

            if (!empty($selectedStatus)) {
                $foods = $foods->filter(function ($food) use ($selectedStatus) {
                    return $food['status'] === $selectedStatus;
                });
            }

            if (!empty($selectedOwner)) {
                $foods = $foods->filter(function ($food) use ($selectedOwner) {
                    return $food['owner'] === $selectedOwner;
                });
            }

            $foods = $foods->sortBy(function ($food) {
                $iconOrder = ['❌' => 0, '⚠️' => 1, '✅' => 2, '❓' => 3];
                return $iconOrder[$food['icon']] ?? 4;
            })->values();

            return view('admin.foods', [
                'foods' => $foods,
                'categories' => $categories,
                'owners' => $owners
            ]);
        }

        return back()->with('error', 'Gagal mengambil data makanan');
    }

    public function getAdminRecipes()
    {
        $token = Session::get('token');
        if (!$token) {
            return redirect('/login');
        }

        $response = Http::withToken($token)->get($this->api.'/admin/recipes');
        
        // Debug log untuk melihat response dari API
        \Illuminate\Support\Facades\Log::info('Admin Recipes API Response:', [
            'status' => $response->status(),
            'body' => $response->json()
        ]);
        
        if ($response->successful()) {
            $recipes = $response->json();
            
            if (!is_array($recipes)) {
                $recipes = [];
            }

            // Map data dari API ke format yang diharapkan view
            $recipes = collect($recipes)->map(function ($recipe) {
                // Handle ingredients based on its type
                $ingredients = [];
                if (isset($recipe['ingredients'])) {
                    if (is_string($recipe['ingredients'])) {
                        $ingredients = explode(',', $recipe['ingredients']);
                    } elseif (is_array($recipe['ingredients'])) {
                        $ingredients = $recipe['ingredients'];
                    }
                }

                // Debug log untuk melihat field creator
                \Illuminate\Support\Facades\Log::info('Recipe Data:', [
                    'recipe' => $recipe,
                    'available_fields' => array_keys($recipe)
                ]);

                // Prioritize createdBy field for creator
                $creator = $recipe['createdBy'] ?? null;
                
                // If createdBy is not available, check other possible fields
                if (empty($creator)) {
                    foreach (['userName', 'user_name', 'username', 'user', 'creator'] as $field) {
                        if (!empty($recipe[$field])) {
                            $creator = $recipe[$field];
                            break;
                        }
                    }
                }

                return [
                    'id' => $recipe['id'] ?? null,
                    'name' => $recipe['recipe_name'] ?? $recipe['name'] ?? 'Tidak ada nama',
                    'ingredients' => $ingredients,
                    'creator' => $creator ?? 'Tidak ada pembuat',
                    'created_at' => $recipe['created_at'] ?? $recipe['createdAt'] ?? null
                ];
            })->toArray();

            // Debug log untuk data yang akan dikirim ke view
            \Illuminate\Support\Facades\Log::info('Final Recipes Data:', [
                'first_recipe' => !empty($recipes) ? $recipes[0] : null,
                'total_recipes' => count($recipes)
            ]);

            return view('admin.recipes', ['recipes' => $recipes]);
        }

        return back()->with('error', 'Gagal mengambil data resep');
    }

    public function getAdminLogs()
    {
        $token = Session::get('token');
        if (!$token) {
            return redirect('/login');
        }

        $response = Http::withToken($token)->get($this->api.'/admin/logs');
        if ($response->successful()) {
            $logs = $response->json() ?? [];
            if (!is_array($logs)) {
                $logs = [$logs];
            }
            return view('admin.logs', ['logs' => $logs]);
        }

        return back()->with('error', 'Gagal mengambil log aktivitas');
    }

    public function deleteCategory($id)
    {
        $token = Session::get('token');
        if (!$token) {
            return redirect('/login');
        }

        $response = Http::withToken($token)->delete($this->api.'/admin/category/'.$id);
        if ($response->successful()) {
            return back()->with('success', 'Kategori berhasil dihapus');
        }

        return back()->with('error', 'Gagal menghapus kategori: ' . ($response->json()['error'] ?? 'Unknown error'));
    }

    public function addCategory(Request $r)
    {
        $token = Session::get('token');
        if (!$token) {
            return redirect('/login');
        }

        $response = Http::withToken($token)->post($this->api.'/admin/category', [
            'name' => $r->name
        ]);

        if ($response->successful()) {
            return back()->with('success', 'Kategori berhasil ditambahkan');
        }

        return back()->with('error', 'Gagal menambah kategori: ' . ($response->json()['error'] ?? 'Unknown error'));
    }

    public function showPromoteForm($id)
    {
        $token = Session::get('token');
        if (!$token) {
            return redirect('/login');
        }

        $response = Http::withToken($token)->get($this->api.'/users');
        if ($response->successful()) {
            $users = $response->json()['users'];
            $user = collect($users)->firstWhere('id', (int)$id);
            
            if (!$user) {
                return back()->with('error', 'User tidak ditemukan');
            }

            return view('admin.promote', ['user' => $user]);
        }

        return back()->with('error', 'Gagal mengambil data user');
    }

    public function promoteUser(Request $r)
    {
        $token = Session::get('token');
        if (!$token) {
            return redirect('/login');
        }

        // Validate input
        $r->validate([
            'target_user_id' => 'required|integer',
            'new_role_name' => 'required|string|in:admin_inventori,admin_resep,admin_user,user'
        ], [
            'target_user_id.required' => 'ID pengguna harus diisi',
            'target_user_id.integer' => 'ID pengguna harus berupa angka',
            'new_role_name.required' => 'Role baru harus dipilih',
            'new_role_name.in' => 'Role yang dipilih tidak valid'
        ]);

        try {
            $response = Http::withToken($token)
                ->post($this->api.'/admin/promote', [
                    'target_user_id' => (int)$r->target_user_id,
                    'new_role_name' => $r->new_role_name
                ]);

            if ($response->successful()) {
                return redirect('/admin/users')->with('success', 'User berhasil dipromosikan');
            }

            $error = $response->json()['error'] ?? 'Unknown error';
            return back()->with('error', 'Gagal mempromosikan user: ' . $error);
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function getUsers()
    {
        $token = Session::get('token');
        if (!$token) {
            return redirect('/login');
        }

        $response = Http::withToken($token)->get($this->api.'/users');
        if ($response->successful()) {
            $users = collect($response->json()['users']);

            // Apply filters
            $searchQuery = request('search');
            $roleFilter = request('role');

            if (!empty($searchQuery)) {
                $users = $users->filter(function ($user) use ($searchQuery) {
                    return stripos($user['username'], $searchQuery) !== false;
                });
            }

            if (!empty($roleFilter)) {
                $users = $users->filter(function ($user) use ($roleFilter) {
                    return $user['role'] === $roleFilter;
                });
            }

            return view('admin.users', ['users' => $users->values()->all()]);
        }

        return back()->with('error', 'Gagal mengambil data users');
    }

    public function deleteUser($id)
    {
        $token = Session::get('token');
        if (!$token) {
            return redirect('/login');
        }

        // Check if user is super_admin
        if (Session::get('role') !== 'super_admin') {
            return back()->with('error', 'Hanya super admin yang dapat menghapus user');
        }

        // Prevent deleting self
        if (Session::get('user_id') == $id) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri');
        }

        try {
            $response = Http::withToken($token)->delete($this->api.'/users/'.$id);

            if ($response->successful()) {
                return back()->with('success', 'User berhasil dihapus');
            }

            $error = $response->json()['error'] ?? 'Unknown error';
            return back()->with('error', 'Gagal menghapus user: ' . $error);

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function getCategories()
    {
        $token = Session::get('token');
        if (!$token) {
            return redirect('/login');
        }

        $response = Http::withToken($token)->get($this->api.'/categories');
        if ($response->successful()) {
            return view('admin.categories', ['categories' => $response->json()]);
        }

        return back()->with('error', 'Gagal mengambil data kategori');
    }

    public function chat(Request $request)
    {
        try {
            \Log::info('Chat request received:', [
                'message' => $request->message
            ]);

            $response = Http::post($this->api.'/chat', [
                'message' => $request->message
            ]);

            \Log::info('Chat response received:', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            \Log::error('Chat request failed:', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return response()->json([
                'error' => 'Gagal mendapatkan respons dari AI',
                'details' => $response->body()
            ], 500);

        } catch (\Exception $e) {
            \Log::error('Chat request exception:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'error' => 'Terjadi kesalahan',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
