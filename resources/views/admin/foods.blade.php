@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Manajemen Makanan</h1>
        </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
        <form method="GET" action="{{ url('/admin/foods') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Makanan</label>
                <input type="text" name="search" value="{{ request('search') }}" 
                    placeholder="Cari nama makanan..." 
                    class="w-full border border-gray-300 rounded-md px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                <select name="category" class="w-full border border-gray-300 rounded-md px-3 py-2">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category['id'] }}" {{ request('category') == $category['id'] ? 'selected' : '' }}>
                            {{ $category['name'] }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status Kadaluarsa</label>
                <select name="status" class="w-full border border-gray-300 rounded-md px-3 py-2">
                    <option value="">Semua Status</option>
                    <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Kadaluarsa</option>
                    <option value="warning" {{ request('status') == 'warning' ? 'selected' : '' }}>Hampir Kadaluarsa</option>
                    <option value="safe" {{ request('status') == 'safe' ? 'selected' : '' }}>Aman</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Pemilik</label>
                <select name="owner" class="w-full border border-gray-300 rounded-md px-3 py-2">
                    <option value="">Semua Pemilik</option>
                    @foreach($owners as $owner)
                        <option value="{{ $owner }}" {{ request('owner') == $owner ? 'selected' : '' }}>
                            {{ $owner }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                    Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Foods Table -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                    <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Kadaluarsa</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pemilik</th>
                    </tr>
                </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($foods as $food)
                        <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $food['id'] ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $food['name'] ?? 'Unnamed' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $food['quantity'] ?? '0' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        @if(isset($food['expiry_date']) && !empty($food['expiry_date']))
                            {{ \Carbon\Carbon::parse($food['expiry_date'])->format('d/m/Y') }}
                        @else
                            <span class="text-gray-500">Tidak ada tanggal</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $food['status'] == 'expired' ? 'bg-red-100 text-red-800' : 
                               ($food['status'] == 'warning' ? 'bg-yellow-100 text-yellow-800' : 
                               'bg-green-100 text-green-800') }}">
                            {{ $food['status'] == 'expired' ? 'Kadaluarsa' : 
                               ($food['status'] == 'warning' ? 'Hampir Kadaluarsa' : 'Aman') }}
                                </span>
                            </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $food['category_name'] ?? 'Tidak ada kategori' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        @if(isset($food['owner']) && !empty($food['owner']))
                            {{ $food['owner'] }}
                        @else
                            <span class="text-gray-500">Tidak ada pemilik</span>
                        @endif
                    </td>
                    
                        </tr>
                    @empty
                        <tr>
                    <td colspan="8" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                Tidak ada data makanan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
    </div>
</div>
@endsection 