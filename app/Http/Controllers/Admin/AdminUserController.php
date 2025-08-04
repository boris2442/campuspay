<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AdminUserController extends Controller
{
    // public function index(){
    //     $users = User::paginate(10);
    //     return view('pages.users.list-user', compact('users'));
    // }
    public function index(Request $request)
    {
        $role = $request->input('role'); // Ex: ?role=user
        $users = User::when($role, function ($query, $role) {
            return $query->where('role', $role);
        })->paginate(10);

        return view('pages.users.users', compact('users', 'role'));
    }
}
