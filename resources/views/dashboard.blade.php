<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Smart Door — Dashboard
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Statistik --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white rounded-xl shadow p-6 text-center">
                    <p class="text-sm text-gray-500">Total Akses</p>
                    <p class="text-4xl font-bold text-gray-800 mt-1">{{ $total }}</p>
                </div>
                <div class="bg-white rounded-xl shadow p-6 text-center">
                    <p class="text-sm text-gray-500">Akses Diterima</p>
                    <p class="text-4xl font-bold text-green-600 mt-1">{{ $granted }}</p>
                </div>
                <div class="bg-white rounded-xl shadow p-6 text-center">
                    <p class="text-sm text-gray-500">Akses Ditolak</p>
                    <p class="text-4xl font-bold text-red-500 mt-1">{{ $denied }}</p>
                </div>
            </div>

            {{-- Daftar Device --}}
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Perangkat Terdaftar</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-3">Nama</th>
                                <th class="px-4 py-3">Lokasi</th>
                                <th class="px-4 py-3">Token</th>
                                <th class="px-4 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($devices as $device)
                            <tr class="border-t">
                                <td class="px-4 py-3 font-medium">{{ $device->name }}</td>
                                <td class="px-4 py-3">{{ $device->location ?? '-' }}</td>
                                <td class="px-4 py-3 font-mono text-xs text-gray-400">{{ $device->token }}</td>
                                <td class="px-4 py-3">
                                    @if($device->is_active)
                                        <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">Aktif</span>
                                    @else
                                        <span class="bg-red-100 text-red-600 text-xs px-2 py-1 rounded-full">Nonaktif</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-4 py-6 text-center text-gray-400">Belum ada device terdaftar</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Log Akses --}}
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Log Akses Terbaru</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-3">Waktu</th>
                                <th class="px-4 py-3">Device</th>
                                <th class="px-4 py-3">Identifier</th>
                                <th class="px-4 py-3">Metode</th>
                                <th class="px-4 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logs as $log)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="px-4 py-3 text-gray-400 text-xs">{{ $log->created_at->format('d M Y H:i:s') }}</td>
                                <td class="px-4 py-3">{{ $log->device->name ?? '-' }}</td>
                                <td class="px-4 py-3 font-mono">{{ $log->identifier }}</td>
                                <td class="px-4 py-3 capitalize">{{ $log->method }}</td>
                                <td class="px-4 py-3">
                                    @if($log->status === 'granted')
                                        <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">Diterima</span>
                                    @else
                                        <span class="bg-red-100 text-red-600 text-xs px-2 py-1 rounded-full">Ditolak</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-gray-400">Belum ada log akses</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">{{ $logs->links() }}</div>
            </div>

        </div>
    </div>
</x-app-layout>