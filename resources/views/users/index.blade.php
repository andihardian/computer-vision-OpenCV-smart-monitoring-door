<x-app-layout>
    <x-slot name="title">Manajemen User</x-slot>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Manajemen User</h1>
        <a href="{{ route('users.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-user-plus fa-sm mr-1"></i> Tambah User
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar User</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%">
                    <thead class="thead-light">
                        <tr>
                            <th width="40">#</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Terdaftar</th>
                            <th width="120">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td class="text-center text-muted">{{ $users->firstItem() + $loop->index }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center mr-2"
                                        style="width:30px;height:30px;flex-shrink:0">
                                        <span class="text-white" style="font-size:11px;font-weight:700">
                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <div class="font-weight-bold">{{ $user->name }}</div>
                                        @if($user->id === auth()->id())
                                            <small class="text-primary">(Anda)</small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="text-muted small">{{ $user->email }}</td>
                            <td>
                                @if($user->role === 'admin')
                                    <span class="badge badge-primary px-3">Admin</span>
                                @else
                                    <span class="badge badge-secondary px-3">User</span>
                                @endif
                            </td>
                            <td class="text-muted small">{{ $user->created_at->format('d M Y') }}</td>
                            <td class="text-center">
                                <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if($user->id !== auth()->id())
                                <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Hapus user {{ $user->name }}?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="fas fa-users fa-2x mb-2 d-block text-gray-300"></i>
                                Belum ada user terdaftar
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($users->hasPages())
                <div class="mt-3">{{ $users->links() }}</div>
            @endif
        </div>
    </div>
</x-app-layout>