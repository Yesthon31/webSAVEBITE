<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    private $rolePermissions = [
        // Super Admin (role_id: 1) memiliki semua permission
        1 => ['view_food', 'view_recipes', 'view_users', 'view_login_logs', 'add_category', 'delete_category', 'promote_user_to_role', 'manage_categories', 'delete_user'],
        
        // Admin Inventori (role_id: 2)
        2 => ['view_food', 'add_category', 'delete_category', 'manage_categories'],
        
        // Admin Resep (role_id: 3)
        3 => ['view_recipes', 'add_category', 'delete_category', 'manage_categories'],
        
        // Admin User (role_id: 4)
        4 => ['view_users', 'view_login_logs', 'promote_user_to_role'],
        
        // User biasa (role_id: 5)
        5 => []
    ];

    public function handle(Request $request, Closure $next, $permission): Response
    {
        $apiUrl = config('app.golang_api');
        
        // Log request details
        Log::info('Starting permission check', [
            'permission' => $permission,
            'user_id' => Session::get('user_id'),
            'role' => Session::get('role'),
            'token_exists' => Session::has('token'),
            'api_url' => $apiUrl
        ]);

        // Validasi konfigurasi API
        if (empty($apiUrl)) {
            Log::error('Golang API URL not configured');
            return redirect()->back()->with('error', 'Konfigurasi API tidak lengkap. Hubungi administrator.');
        }

        if (!Session::has('token')) {
            Log::warning('No token found in session');
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        // Super admin memiliki akses ke semua fitur
        if (Session::get('role') === 'super_admin') {
            Log::info('Super admin access granted');
            return $next($request);
        }

        try {
            $token = Session::get('token');
            $fullUrl = rtrim($apiUrl, '/') . '/check-permission';
            
            Log::debug('Making API request', [
                'url' => $fullUrl,
                'token_length' => strlen($token),
                'permission' => $permission
            ]);

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json'
            ])->get($fullUrl, [
                'permission' => $permission
            ]);

            Log::debug('API Response received', [
                'status_code' => $response->status(),
                'body' => $response->json(),
                'headers' => $response->headers()
            ]);

            if ($response->successful()) {
                $data = $response->json();
                Log::info('Permission check response', [
                    'has_permission' => $data['has_permission'] ?? false,
                    'response_data' => $data
                ]);

                if (isset($data['has_permission']) && $data['has_permission'] === true) {
                    return $next($request);
                }
            } else {
                Log::error('API returned error response', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'headers' => $response->headers()
                ]);
            }

            // Jika tidak memiliki permission
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Anda tidak memiliki akses untuk fitur ini',
                    'details' => $response->json()
                ], 403);
            }
            
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk fitur ini');

        } catch (\Exception $e) {
            Log::error('Exception during permission check:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'permission' => $permission,
                'user_id' => Session::get('user_id'),
                'role' => Session::get('role'),
                'api_url' => $apiUrl,
                'full_url' => $fullUrl ?? null
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Terjadi kesalahan saat memeriksa akses',
                    'message' => $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memeriksa akses. Pastikan konfigurasi API sudah benar.');
        }
    }
} 