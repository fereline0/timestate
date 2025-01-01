<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::paginate(10);

        return view('dashboard.users.index', compact('users'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if (Auth::user()->id == $user->id) {
            Auth::logout();
        }

        $user->delete();

        return redirect()->route('dashboard.users.index')->with('status', 'user-deleted');
    }
}
