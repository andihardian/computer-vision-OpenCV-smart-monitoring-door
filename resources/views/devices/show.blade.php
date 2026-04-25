<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Device — {{ $device->name }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Info Device --}}
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex justify-between items-start">
                    <div class="space-y-2">
                        <h3 class="text-lg font-semibold text-gray-800">{{ $device->name }}</h3>
                        <p class="text-sm text-gray-500">Lokasi: <span class="text-gray-700">{{ $device->location ?? '-' }}</span></p>
                        <p class="text-sm text-gray-500">Token:
                            <code class="bg-gray-100 px-2 py-0.5 rounded text-xs font-mono">{{ $device->token }}</code>
                        </p>
                        <p class="text-sm text-gray-500">Status:
                            @if($device->is_active)
                                <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">Aktif</span>
                            @else
                                <span class="bg-red-100 text-red-600 text-xs px-2 py-1 rounded-full">Nonaktif</span>
                            @endif
                        </p>
                    </div>

                    @if(auth()->user()->isAdmin())
                    <div class="flex gap-2">
                        <a href="{{ route('devices.edit', $device) }}"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white text-sm px-4 py-2 rounded-lg">
                            Edit
                        </a>
                        <form action="{{ route('devices.regenerate-token', $device) }}" method="POST"
                            onsubmit="return confirm('Regenerate token? Token lama tidak bisa digunakan lagi.')">
                            @csrf
                            <button type="submit"
                                class="bg-purple-600 hover:bg-purple-700 text-white text-sm px-4 py-2 rounded-lg">
                                Regenerate Token
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Log Akses Device --}}
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Log Akses Device Ini</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-3">Waktu</th>
                                <th class="px-4 py-3">Identifier</th>
                                <th class="px-4 py-3">Metode</th>
                                <th class="px-4 py-3">IP</th>
                                <th class="px-4 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logs as $log)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="px-4 py-3 text-gray-400 text-xs">{{ $log->created_at->format('d M Y H:i:s') }}</td>
                                <td class="px-4 py-3 font-mono">{{ $log->identifier }}</td>
                                <td class="px-4 py-3 capitalize">{{ $log->method }}</td>
                                <td class="px-4 py-3 text-gray-400 text-xs">{{ $log->ip_address ?? '-' }}</td>
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
                                <td colspan="5" class="px-4 py-6 text-center text-gray-400">Belum ada log akses untuk device ini</td>
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