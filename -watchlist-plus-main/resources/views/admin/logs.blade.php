@extends('layouts.app')
@section('title', 'Admin — Audit Logs')

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
            <h1>Audit Logs</h1>
            <span class="admin-badge">{{ $logs->total() }} records</span>
        </div>

        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Date & Time</th>
                        <th>Admin (ID)</th>
                        <th>Action Performed</th>
                        <th>Target Entity</th>
                        <th>Target ID</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr>
                            <td class="td--muted">{{ $log->timestamp->format('d M Y, H:i') }}</td>
                            <td><strong>{{ $log->user->name ?? 'Unknown' }}</strong> (#{{ $log->user_id }})</td>
                            <td>
                                <span class="status-badge {{ $log->action === 'BLOCK_USER' ? 'status--blocked' : 'status--active' }}">
                                    {{ str_replace('_', ' ', $log->action) }}
                                </span>
                            </td>
                            <td class="td--muted">{{ $log->entity }}</td>
                            <td class="td--muted">#{{ $log->entity_id }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="table-empty">No audit logs found.</td>
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
/* Reusing your partner's beautiful CSS variables and layout */
.admin-page { display: flex; min-height: calc(100vh - 70px); }
.admin-sidebar { width: 220px; flex-shrink: 0; background: var(--color-surface); border-right: 1px solid var(--color-border); padding: 2rem 1.5rem; }
.admin-sidebar__title { font-family: var(--font-display); font-size: 1.5rem; letter-spacing: 1px; color: var(--color-accent); margin-bottom: 1.5rem; }
.admin-nav { display: flex; flex-direction: column; gap: 0.25rem; }
.admin-nav a { color: var(--color-muted); text-decoration: none; font-size: 0.9rem; padding: 0.6rem 0.85rem; border-radius: 6px; transition: all 0.2s; display: flex; align-items: center; gap: 0.5rem; }
.admin-nav a:hover { background: var(--color-bg); color: var(--color-text); }
.admin-nav a.active { background: rgba(232,70,42,0.1); color: var(--color-accent); }
.admin-content { flex: 1; padding: 2.5rem; overflow-x: auto; min-width: 0; }
.admin-content__header { display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem; }
.admin-content__header h1 { font-family: var(--font-display); font-size: 2.2rem; letter-spacing: 0.5px; }
.admin-badge { background: var(--color-surface); border: 1px solid var(--color-border); border-radius: 20px; padding: 0.2rem 0.8rem; font-size: 0.78rem; color: var(--color-muted); }
.admin-table-wrap { border: 1px solid var(--color-border); border-radius: 10px; overflow: hidden; overflow-x: auto; }
.admin-table { width: 100%; border-collapse: collapse; }
.admin-table thead { background: var(--color-surface); }
.admin-table th { padding: 0.8rem 1rem; text-align: left; font-size: 0.72rem; font-weight: 700; letter-spacing: 0.6px; color: var(--color-muted); text-transform: uppercase; border-bottom: 1px solid var(--color-border); white-space: nowrap; }
.admin-table td { padding: 0.85rem 1rem; font-size: 0.88rem; border-bottom: 1px solid rgba(30,30,46,0.6); vertical-align: middle; }
.admin-table tr:last-child td { border-bottom: none; }
.admin-table tbody tr:hover td { background: rgba(255,255,255,0.015); }
.td--muted { color: var(--color-muted); }
.table-empty { text-align: center; color: var(--color-muted); padding: 2.5rem !important; }
.status-badge { font-size: 0.72rem; font-weight: 600; padding: 0.2rem 0.6rem; border-radius: 20px; text-transform: uppercase; }
.status--active  { background: rgba(111,207,111,0.1); color: #6fcf6f; }
.status--blocked { background: rgba(224,112,112,0.1); color: #e07070; }
.admin-pagination { margin-top: 1.5rem; display: flex; justify-content: flex-end; }
</style>
@endpush