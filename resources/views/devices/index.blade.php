<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manajemen Device
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            {{-- Alert --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-700">Daftar Device</h3>
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('devices.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded-lg">
                            + Tambah Device
                        </a>
                    @endif
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-3">#</th>
                                <th class="px-4 py-3">Nama</th>
                                <th class="px-4 py-3">Lokasi</th>
                                <th class="px-4 py-3">Token</th>
                                <th class="px-4 py-3">Total Akses</th>
                                <th class="px-4 py-3">Status</th>
                                @if(auth()->user()->isAdmin())
                                    <th class="px-4 py-3">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($devices as $i => $device)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="px-4 py-3 text-gray-400">{{ $i + 1 }}</td>
                                <td class="px-4 py-3 font-medium">
                                    <a href="{{ route('devices.show', $device) }}" class="text-blue-600 hover:underline">
                                        {{ $device->name }}
                                    </a>
                                </td>
                                <td class="px-4 py-3">{{ $device->location ?? '-' }}</td>
                                <td class="px-4 py-3 font-mono text-xs text-gray-400">{{ $device->token }}</td>
                                <td class="px-4 py-3">{{ $device->access_logs_count }}</td>
                                <td class="px-4 py-3">
                                    @if($device->is_active)
                                        <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">Aktif</span>
                                    @else
                                        <span class="bg-red-100 text-red-600 text-xs px-2 py-1 rounded-full">Nonaktif</span>
                                    @endif
                                </td>
                                @if(auth()->user()->isAdmin())
                                <td class="px-4 py-3 flex gap-2">
                                    <a href="{{ route('devices.edit', $device) }}" class="text-yellow-600 hover:underline text-xs">Edit</a>
                                    <form action="{{ route('devices.destroy', $device) }}" method="POST" onsubmit="return confirm('Hapus device ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline text-xs">Hapus</button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-4 py-6 text-center text-gray-400">Belum ada device terdaftar</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>