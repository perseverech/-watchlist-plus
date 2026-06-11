{{-- ============================================================
     FILE: resources/views/admin/logs.blade.php
     Admin panel — audit logs table

     ⚠️ DEPENDS ON AL'ZHANA — AdminController@logs must pass:
       $logs = AuditLog::with('user')->latest('timestamp')->paginate(30)
       Each log has: ->id, ->action, ->entity, ->entity_id,
                     ->timestamp, ->user->username
     ============================================================ --}}
@extends('layouts.app')
@section('title', 'Admin — Audit Logs')

@section('content')
<div class="admin-page">

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

    <div class="admin-content">

        <div class="admin-content__header">
            <h1>Audit Logs</h1>
        </div>

        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Timestamp</th>
                        <th>User</th>
                        <th>Action</th>
                        <th>Entity</th>
                        <th>Entity ID</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr>
                            <td class="td--muted">#{{ $log->id }}</td>
                            <td class="td--muted td--nowrap">
                                {{-- ⚠️ DEPENDS ON AL'ZHANA: ->timestamp column name --}}
                                {{ \Carbon\Carbon::parse($log->timestamp)->format('d M Y, H:i') }}
                            </td>
                            <td>{{ $log->user->username ?? '—' }}</td>
                            <td>
                                {{-- Color-coded action badge based on first word --}}
                                @php
                                    $actionWord = strtolower(explode('_', $log->action)[0]);
                                @endphp
                                <span class="action-log-badge action-log--{{ $actionWord }}">
                                    {{ $log->action }}
                                </span>
                            </td>
                            <td class="td--muted">{{ $log->entity }}</td>
                            <td class="td--muted">{{ $log->entity_id }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="table-empty">No logs recorded yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="admin-pagination">
            {{ $logs->links() }}
        </div>

    </div>
</div>
@endsection

@push('styles')
<style>
/* Sidebar + layout same as admin/users.blade.php */
.admin-page { display: flex; min-height: calc(100vh - 70px); }
.admin-sidebar {
    width: 220px; flex-shrink: 0;
    background: var(--color-surface);
    border-right: 1px solid var(--color-border);
    padding: 2rem 1.5rem;
}
.admin-sidebar__title { font-family: var(--font-display); font-size: 1.5rem; letter-spacing: 1px; color: var(--color-accent); margin-bottom: 1.5rem; }
.admin-nav { display: flex; flex-direction: column; gap: 0.25rem; }
.admin-nav a { color: var(--color-muted); text-decoration: none; font-size: 0.9rem; padding: 0.6rem 0.85rem; border-radius: 6px; transition: all 0.2s; display: flex; align-items: center; gap: 0.5rem; }
.admin-nav a:hover { background: var(--color-bg); color: var(--color-text); }
.admin-nav a.active { background: rgba(232,70,42,0.1); color: var(--color-accent); }

.admin-content { flex: 1; padding: 2.5rem; overflow-x: auto; min-width: 0; }
.admin-content__header { display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem; }
.admin-content__header h1 { font-family: var(--font-display); font-size: 2.2rem; letter-spacing: 0.5px; }

.admin-table-wrap { border: 1px solid var(--color-border); border-radius: 10px; overflow: hidden; overflow-x: auto; }
.admin-table { width: 100%; border-collapse: collapse; }
.admin-table thead { background: var(--color-surface); }
.admin-table th { padding: 0.8rem 1rem; text-align: left; font-size: 0.72rem; font-weight: 700; letter-spacing: 0.6px; color: var(--color-muted); text-transform: uppercase; border-bottom: 1px solid var(--color-border); white-space: nowrap; }
.admin-table td { padding: 0.85rem 1rem; font-size: 0.88rem; border-bottom: 1px solid rgba(30,30,46,0.6); vertical-align: middle; }
.admin-table tr:last-child td { border-bottom: none; }
.admin-table tbody tr:hover td { background: rgba(255,255,255,0.015); }
.td--muted { color: var(--color-muted); }
.td--nowrap { white-space: nowrap; }
.table-empty { text-align: center; color: var(--color-muted); padding: 2.5rem !important; }

/* Action badge — color varies by action type */
.action-log-badge {
    font-size: 0.68rem;
    font-weight: 700;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    padding: 0.2rem 0.55rem;
    border-radius: 4px;
    font-family: monospace;
    white-space: nowrap;
}
.action-log--block,
.action-log--delete  { background: rgba(224,112,112,0.1); color: #e07070; }
.action-log--create,
.action-log--unblock { background: rgba(111,207,111,0.1); color: #6fcf6f; }
.action-log--update  { background: rgba(245,166,35,0.1);  color: var(--color-accent2); }
.action-log--login,
.action-log--logout  { background: rgba(100,150,255,0.1); color: #8aadff; }

.admin-pagination { margin-top: 1.5rem; display: flex; justify-content: flex-end; }
</style>
@endpush

