<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        /** @var User $user */
        $user = $request->user('web');

        $isAdmin = $user->hasRole('admin');

        $tasks = $isAdmin ? Task::query()->orderBy('id', 'desc')->with('user')->paginate(
            25
        ) : null;

        return view('dashboard', [
            'user' => $user,
            'tasks' => $tasks,
            'is_admin' => $isAdmin,
        ]);
    }
}
