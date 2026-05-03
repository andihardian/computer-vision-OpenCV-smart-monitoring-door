<x-app-layout>
    <x-slot name="title">Manajemen User</x-slot>

    @push('styles')
    <style>
        :root {
            --navy:       #0F2044;
            --blue:       #1E6FD9;
            --success:    #10B981;
            --danger:     #EF4444;
            --warning:    #F59E0B;
            --info:       #06B6D4;
            --card:       #FFFFFF;
            --border:     #E2E8F0;
            --text-main:  #0F2044;
            --text-muted: #64748B;
            --text-faint: #94A3B8;
            --radius:     16px;
            --radius-sm:  10px;
            --shadow:     0 2px 16px rgba(15,32,68,0.08);
        }

        .page { animation: fadeUp 0.4s ease both; }

        @keyframes fadeUp {
            from { opacity:0; transform:translateY(12px); }
            to   { opacity:1; transform:translateY(0); }
        }

        /* Page Header */
        .page-header {
            display:flex; align-items:center; justify-content:space-between;
            margin-bottom:28px; flex-wrap:wrap; gap:12px;
        }
        .page-header h1 {
            font-size:1.5rem; font-weight:800; color:var(--text-main);
            margin:0 0 2px; letter-spacing:-0.3px;
        }
        .page-header p { font-size:0.82rem; color:var(--text-muted); margin:0; }

        .btn-primary-custom {
            display:inline-flex; align-items:center; gap:7px;
            padding:9px 18px; background:var(--blue); color:#fff;
            border:none; border-radius:var(--radius-sm); font-size:0.82rem;
            font-weight:700; cursor:pointer; text-decoration:none;
            transition:background 0.2s, transform 0.1s;
        }
        .btn-primary-custom:hover { background:#1558b0; transform:translateY(-1px); color:#fff; }

        /* SD Card */
        .sd-card {
            background:var(--card); border-radius:var(--radius);
            border:1px solid var(--border); box-shadow:var(--shadow); overflow:hidden;
        }
        .sd-card-header {
            display:flex; align-items:center; justify-content:space-between;
            padding:18px 20px 16px; border-bottom:1px solid var(--border);
        }
        .sd-card-title { font-size:0.9rem; font-weight:700; color:var(--text-main); }
        .sd-card-subtitle { font-size:0.78rem; color:var(--text-muted); }

        /* Table */
        .sd-table { width:100%; border-collapse:collapse; font-size:0.83rem; }
        .sd-table thead th {
            padding:10px 16px; font-size:0.68rem; font-weight:700;
            text-transform:uppercase; letter-spacing:0.6px; color:var(--text-faint);
            background:#F8FAFC; border-bottom:1px solid var(--border); white-space:nowrap;
        }
        .sd-table tbody td {
            padding:14px 16px; color:var(--text-main);
            border-bottom:1px solid #F1F5F9; vertical-align:middle;
        }
        .sd-table tbody tr:last-child td { border-bottom:none; }
        .sd-table tbody tr:hover td { background:#F8FAFC; }

        /* Avatar */
        .user-avatar {
            width:36px; height:36px; border-radius:10px;
            background:linear-gradient(135deg, var(--blue), #3B82F6);
            display:flex; align-items:center; justify-content:center;
            font-size:0.72rem; font-weight:800; color:#fff; flex-shrink:0;
        }
        .user-name { font-weight:700; color:var(--text-main); }
        .user-you  {
            display:inline-block; font-size:0.65rem; font-weight:700;
            background:rgba(30,111,217,0.1); color:var(--blue);
            border-radius:100px; padding:1px 8px; margin-left:6px;
        }

        /* Role badges */
        .badge-role {
            display:inline-flex; align-items:center; gap:5px;
            padding:3px 10px; border-radius:100px;
            font-size:0.7rem; font-weight:700; white-space:nowrap;
        }
        .badge-admin { background:rgba(30,111,217,0.1); color:var(--blue); }
        .badge-user  { background:#F1F5F9; color:var(--text-muted); }

        /* Action buttons */
        .action-btn {
            display:inline-flex; align-items:center; justify-content:center;
            width:32px; height:32px; border-radius:8px; border:none;
            font-size:0.8rem; cursor:pointer; text-decoration:none;
            transition:opacity 0.15s, transform 0.1s;
        }
        .action-btn:hover { opacity:0.8; transform:translateY(-1px); }
        .btn-edit   { background:rgba(245,158,11,0.12); color:var(--warning); }
        .btn-delete { background:rgba(239,68,68,0.1);   color:var(--danger); }

        /* Empty state */
        .empty-state { text-align:center; padding:60px 20px; color:var(--text-faint); }
        .empty-state i { font-size:2rem; margin-bottom:12px; display:block; opacity:0.3; }
        .empty-state p { margin:0; font-size:0.85rem; }

        /* Pagination */
        .card-footer-custom { padding:14px 20px; border-top:1px solid var(--border); background:#FAFBFD; }

        @media (max-width:768px) {
            .page-header { flex-direction:column; align-items:flex-start; }
            .hide-mobile { display:none; }
        }
    </style>
    @endpush

    <div class="page">

        <div class="page-header">
            <div>
                <h1><i class="fas fa-users" style="color:var(--warning);margin-right:10px;font-size:1.2rem"></i>Manajemen User</h1>
                <p>Kelola akun dan hak akses pengguna sistem</p>
            </div>
            <a href="{{ route('users.create') }}" class="btn-primary-custom">
                <i class="fas fa-user-plus"></i> Tambah User
            </a>
        </div>

        <div class="sd-card">
            <div class="sd-card-header">
                <span class="sd-card-title">
                    <i class="fas fa-list" style="color:var(--blue);margin-right:8px;font-size:0.85rem"></i>
                    Daftar User
                </span>
                <span class="sd-card-subtitle">{{ $users->total() }} user terdaftar</span>
            </div>
            <table class="sd-table">
                <thead>
                    <tr>
                        <th width="40">#</th>
                        <th>Nama</th>
                        <th class="hide-mobile">Email</th>
                        <th>Role</th>
                        <th class="hide-mobile">Terdaftar</th>
                        <th width="90">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td style="color:var(--text-faint);font-size:0.75rem;text-align:center">
                            {{ $users->firstItem() + $loop->index }}
                        </td>
                        <td>
                            <div style="display:flex;align-items:center;gap:10px">
                                <div class="user-avatar">{{ strtoupper(substr($user->name, 0, 2)) }}</div>
                                <div>
                                    <div class="user-name">
                                        {{ $user->name }}
                                        @if($user->id === auth()->id())
                                            <span class="user-you">Anda</span>
                                        @endif
                                    </div>
                                    <div class="hide-mobile" style="display:none"></div>
                                </div>
                            </div>
                        </td>
                        <td class="hide-mobile" style="font-size:0.8rem;color:var(--text-muted)">{{ $user->email }}</td>
                        <td>
                            @if($user->role === 'admin')
                                <span class="badge-role badge-admin"><i class="fas fa-shield-alt" style="font-size:0.6rem"></i> Admin</span>
                            @else
                                <span class="badge-role badge-user"><i class="fas fa-user" style="font-size:0.6rem"></i> User</span>
                            @endif
                        </td>
                        <td class="hide-mobile" style="font-size:0.78rem;color:var(--text-faint)">
                            {{ $user->created_at->format('d M Y') }}
                        </td>
                        <td>
                            <div style="display:flex;gap:6px;align-items:center">
                                <a href="{{ route('users.edit', $user) }}" class="action-btn btn-edit" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if($user->id !== auth()->id())
                                <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Hapus user {{ $user->name }}?')">
                                    @csrf @method('DELETE')
                                    <button class="action-btn btn-delete" title="Hapus" type="submit">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <i class="fas fa-users"></i>
                                <p>Belum ada user terdaftar</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            @if($users->hasPages())
            <div class="card-footer-custom">{{ $users->links() }}</div>
            @endif
        </div>

    </div>
</x-app-layout>