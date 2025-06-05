@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Pengguna</h1>
        </div>

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Filter Section -->
        <div class="mb-6">
            <form method="GET" action="{{ url('/admin/users') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                    <input type="text" name="search" value="{{ request('search') }}" 
                        placeholder="Cari username..." 
                        class="w-full border border-gray-300 rounded-md px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                    <select name="role" class="w-full border border-gray-300 rounded-md px-3 py-2">
                        <option value="">Semua Role</option>
                        <option value="super_admin" {{ request('role') == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                        <option value="admin_inventori" {{ request('role') == 'admin_inventori' ? 'selected' : '' }}>Admin Inventori</option>
                        <option value="admin_resep" {{ request('role') == 'admin_resep' ? 'selected' : '' }}>Admin Resep</option>
                        <option value="admin_user" {{ request('role') == 'admin_user' ? 'selected' : '' }}>Admin User</option>
                        <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                        Filter
                    </button>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm font-semibold text-gray-600">ID</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm font-semibold text-gray-600">Username</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm font-semibold text-gray-600">Email</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm font-semibold text-gray-600">Current Role</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm font-semibold text-gray-600">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 border-b text-sm">{{ $user['id'] }}</td>
                            <td class="px-6 py-4 border-b text-sm">{{ $user['username'] }}</td>
                            <td class="px-6 py-4 border-b text-sm">{{ $user['email'] }}</td>
                            <td class="px-6 py-4 border-b text-sm">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold
                                    @if($user['role'] === 'super_admin') bg-purple-100 text-purple-800
                                    @elseif($user['role'] === 'admin_inventori') bg-blue-100 text-blue-800
                                    @elseif($user['role'] === 'admin_resep') bg-green-100 text-green-800
                                    @elseif($user['role'] === 'admin_user') bg-yellow-100 text-yellow-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ $user['role'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 border-b text-sm">
                                @if(Session::get('role') === 'super_admin' && $user['role'] !== 'super_admin')
                                    <div class="flex items-center space-x-2">
                                        <form method="POST" action="{{ url('/admin/promote') }}" class="flex items-center space-x-2">
                                            @csrf
                                            <input type="hidden" name="target_user_id" value="{{ (int)$user['id'] }}">
                                            <select name="new_role_name" 
                                                    class="text-sm border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                                <option value="">Select role</option>
                                                <option value="admin_inventori" @if($user['role'] === 'admin_inventori') selected @endif>Admin Inventori</option>
                                                <option value="admin_resep" @if($user['role'] === 'admin_resep') selected @endif>Admin Resep</option>
                                                <option value="admin_user" @if($user['role'] === 'admin_user') selected @endif>Admin User</option>
                                                <option value="user" @if($user['role'] === 'user') selected @endif>User</option>
                                            </select>
                                            <button type="submit" 
                                                    class="inline-flex items-center px-3 py-1 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                                Update
                                            </button>
                                        </form>

                                        <form method="POST" action="{{ url('/admin/users/'.$user['id']) }}" 
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini? Semua data terkait user ini (makanan, resep, log) akan ikut terhapus. Aksi ini tidak dapat dibatalkan.')" 
                                              class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="inline-flex items-center px-3 py-1 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-gray-400 text-xs">No actions available</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 border-b text-center text-gray-500">
                                No users found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection 