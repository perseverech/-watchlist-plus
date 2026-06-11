<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::paginate(20);

        return view('admin.users', compact('users'));
    }

    public function block($id)
    {
        $user = User::findOrFail($id);

        if ($user->blocked_at) {
            $user->blocked_at = null;
            $action = 'UNBLOCK_USER';
        } else {
            $user->blocked_at = now();
            $action = 'BLOCK_USER';
        }

        $user->save();

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'entity' => 'User',
            'entity_id' => $id,
            'timestamp' => now(),
        ]);

        $verb = $action === 'BLOCK_USER' ? 'blocked' : 'unblocked';

        return back()->with('success', "User {$user->name} has been {$verb}.");
    }

    public function logs()
    {
        $logs = AuditLog::with('user')
            ->latest('timestamp')
            ->paginate(30);

        return view('admin.logs', compact('logs'));
    }
}