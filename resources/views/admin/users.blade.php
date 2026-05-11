{{-- ============================================================
     FILE: resources/views/admin/users.blade.php
     Admin panel — user list with block/unblock

     ⚠️ DEPENDS ON AL'ZHANA — AdminController@index must pass:
       $users = User::with('role')->paginate(20)
       Each user has: ->id, ->username, ->email, ->created_at
                      ->role->name, ->blocked_at (null = active)
     ============================================================ --}}
@extends('layouts.app')
@section('title', 'Admin — Users')

@section('content')
<div class="admin-page">

    {{-- Sidebar --}}
    <aside class="admin-sidebar">
        <h2 class="admin-sidebar__title">Admin</h2>
        <nav class="admin-nav">
            <a href="{{ route('admin.users') }}"
               class="{{ request()->routeIs('admin.users') ? 'active' : '' }}">
                👤 Users
            </a>
            <a href="{{ route('admin.logs') }}"
               class="{{ request()->routeIs('admin.logs') ? 'active' : '' }}">
                📋 Audit Logs
            </a>
        </nav>
    </aside>

    {{-- Main content --}}
    <div class="admin-content">

        <div class="admin-content__header">
            <h1>User Management</h1>
            <span class="admin-badge">{{ $users->total() }} total</span>
        </div>

        @if(session('success'))
            <div class="admin-alert admin-alert--success">{{ session('success') }}</div>
        @endif

        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Joined</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr class="{{ $user->blocked_at ? 'row--blocked' : '' }}">
                            <td class="td--muted">#{{ $user->id }}</td>
                            <td><strong>{{ $user->username }}</strong></td>
                            <td class="td--muted">{{ $user->email }}</td>
                            <td>
                                {{-- ⚠️ DEPENDS ON AL'ZHANA: role->name values --}}
                                <span class="role-badge role--{{ strtolower($user->role->name ?? 'user') }}">
                                    {{ $user->role->name ?? 'user' }}
                                </span>
                            </td>
                            <td class="td--muted">
                                {{ \Carbon\Carbon::parse($user->created_at)->format('d M Y') }}
                            </td>
                            <td>
                                @if($user->blocked_at)
                                    <span class="status-badge status--blocked">Blocked</span>
                                @else
                                    <span class="status-badge status--active">Active</span>
                                @endif
                            </td>
                            <td>
                                {{-- Cannot block yourself --}}
                                @if($user->id !== auth()->id())
                                    <form method="POST" action="{{ route('admin.block', $user->id) }}" style="display:inline">
                                        @csrf
                                        <button
                                            type="submit"
                                            class="action-btn {{ $user->blocked_at ? 'action-btn--unblock' : 'action-btn--block' }}"
                                            onclick="return confirm('{{ $user->blocked_at ? 'Unblock' : 'Block' }} {{ $user->username }}?')"
                                        >
                                            {{ $user->blocked_at ? 'Unblock' : 'Block' }}
                                        </button>
                                    </form>
                                @else
                                    <span class="td--muted">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="table-empty">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="admin-pagination">
            {{ $users->links() }}
        </div>

    </div>
</div>
@endsection

@push('styles')
<style>
/* Admin shared layout */
.admin-page { display: flex; min-height: calc(100vh - 70px); }

.admin-sidebar {
    width: 220px;
    flex-shrink: 0;
    background: var(--color-surface);
    border-right: 1px solid var(--color-border);
    padding: 2rem 1.5rem;
}
.admin-sidebar__title {
    font-family: var(--font-display);
    font-size: 1.5rem;
    letter-spacing: 1px;
    color: var(--color-accent);
    margin-bottom: 1.5rem;
}
.admin-nav { display: flex; flex-direction: column; gap: 0.25rem; }
.admin-nav a {
    color: var(--color-muted);
    text-decoration: none;
    font-size: 0.9rem;
    padding: 0.6rem 0.85rem;
    border-radius: 6px;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.admin-nav a:hover { background: var(--color-bg); color: var(--color-text); }
.admin-nav a.active { background: rgba(232,70,42,0.1); color: var(--color-accent); }

.admin-content { flex: 1; padding: 2.5rem; overflow-x: auto; min-width: 0; }
.admin-content__header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
}
.admin-content__header h1 {
    font-family: var(--font-display);
    font-size: 2.2rem;
    letter-spacing: 0.5px;
}
.admin-badge {
    background: var(--color-surface);
    border: 1px solid var(--color-border);
    border-radius: 20px;
    padding: 0.2rem 0.8rem;
    font-size: 0.78rem;
    color: var(--color-muted);
}

.admin-alert {
    padding: 0.8rem 1rem;
    border-radius: 8px;
    margin-bottom: 1.2rem;
    font-size: 0.88rem;
}
.admin-alert--success { background: #1a3a1a; color: #6fcf6f; border: 1px solid #2d5a2d; }

/* Table */
.admin-table-wrap {
    border: 1px solid var(--color-border);
    border-radius: 10px;
    overflow: hidden;
    overflow-x: auto;
}
.admin-table { width: 100%; border-collapse: collapse; }
.admin-table thead { background: var(--color-surface); }
.admin-table th {
    padding: 0.8rem 1rem;
    text-align: left;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.6px;
    color: var(--color-muted);
    text-transform: uppercase;
    border-bottom: 1px solid var(--color-border);
    white-space: nowrap;
}
.admin-table td {
    padding: 0.85rem 1rem;
    font-size: 0.88rem;
    border-bottom: 1px solid rgba(30,30,46,0.6);
    vertical-align: middle;
}
.admin-table tr:last-child td { border-bottom: none; }
.admin-table tbody tr:hover td { background: rgba(255,255,255,0.015); }
.row--blocked td { opacity: 0.5; }
.td--muted { color: var(--color-muted); }
.table-empty { text-align: center; color: var(--color-muted); padding: 2.5rem !important; }

.role-badge {
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    padding: 0.2rem 0.55rem;
    border-radius: 4px;
}
.role--admin     { background: rgba(232,70,42,0.12); color: var(--color-accent); }
.role--moderator { background: rgba(245,166,35,0.12); color: var(--color-accent2); }
.role--user      { background: var(--color-border); color: var(--color-muted); }

.status-badge {
    font-size: 0.72rem;
    font-weight: 600;
    padding: 0.2rem 0.6rem;
    border-radius: 20px;
}
.status--active  { background: rgba(111,207,111,0.1); color: #6fcf6f; }
.status--blocked { background: rgba(224,112,112,0.1); color: #e07070; }

.action-btn {
    padding: 0.32rem 0.8rem;
    border-radius: 6px;
    font-size: 0.78rem;
    font-family: var(--font-body);
    font-weight: 500;
    cursor: pointer;
    border: 1px solid var(--color-border);
    background: transparent;
    transition: all 0.18s;
    white-space: nowrap;
}
.action-btn--block  { color: #e07070; border-color: rgba(224,112,112,0.25); }
.action-btn--block:hover { background: rgba(224,112,112,0.08); }
.action-btn--unblock { color: #6fcf6f; border-color: rgba(111,207,111,0.25); }
.action-btn--unblock:hover { background: rgba(111,207,111,0.08); }

.admin-pagination { margin-top: 1.5rem; display: flex; justify-content: flex-end; }
</style>
@endpush

