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
    }

    public function index()
    {
        $users = User::paginate(20);
        return view('admin.users', compact('users'));
    }

    public function block($id)
    {
        $user = User::findOrFail($id);

        if ($user->is_blocked) {
            $user->is_blocked = false;
            $action           = 'UNBLOCK_USER';
        } else {
            $user->is_blocked = true;
            $action           = 'BLOCK_USER';
        }
        $user->save();

        AuditLog::create([
            'user_id'   => auth()->id(),
            'action'    => $action,
            'entity'    => 'User',
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