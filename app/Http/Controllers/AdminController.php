<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AuditLog;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // ⚠️ DEPENDS ON AL'ZHANA: Add 'admin' middleware once she creates it
        // $this->middleware('admin');
    }

    /**
     * GET /admin/users
     * Renders admin/users.blade.php
     */
    public function index()
    {
        $users = User::with('role')->paginate(20);
        return view('admin.users', compact('users'));
    }

    /**
     * POST /admin/users/{id}/block
     */
    public function block($id)
    {
        $user = User::findOrFail($id);

        if ($user->blocked_at) {
            $user->blocked_at = null;
            $action           = 'UNBLOCK_USER';
        } else {
            $user->blocked_at = now();
            $action           = 'BLOCK_USER';
        }
        $user->save();

        // ⚠️ DEPENDS ON AL'ZHANA: AuditLog model
        AuditLog::create([
            'user_id'   => auth()->id(),
            'action'    => $action,
            'entity'    => 'User',
            'entity_id' => $id,
            'timestamp' => now(),
        ]);

        $verb = $action === 'BLOCK_USER' ? 'blocked' : 'unblocked';
        return back()->with('success', "User {$user->username} has been {$verb}.");
    }

    /**
     * GET /admin/logs
     * Renders admin/logs.blade.php
     */
    public function logs()
    {
        $logs = AuditLog::with('user')
            ->latest('timestamp')
            ->paginate(30);

        return view('admin.logs', compact('logs'));
    }
}
