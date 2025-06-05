@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8 flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-800">Manajemen Resep</h1>
    </div>

    <!-- Recipes Table -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Resep</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bahan-bahan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pembuat</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Dibuat</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($recipes as $recipe)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $recipe['id'] ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $recipe['name'] }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        @if(!empty($recipe['ingredients']))
                            <ul class="list-disc list-inside">
                                @foreach($recipe['ingredients'] as $ingredient)
                                    <li>{{ trim($ingredient) }}</li>
                                @endforeach
                            </ul>
                        @else
                            <span class="text-gray-500">Tidak ada bahan</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        @if(!empty($recipe['creator']))
                            {{ $recipe['creator'] }}
                        @else
                            <span class="text-gray-500">Tidak ada pembuat</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        @if(!empty($recipe['created_at']))
                            {{ \Carbon\Carbon::parse($recipe['created_at'])->format('d/m/Y H:i') }}
                        @else
                            <span class="text-gray-500">Tidak ada tanggal</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                        Tidak ada data resep
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection 