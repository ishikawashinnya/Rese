<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function create() {
        return view('admin.create_representative');
    }

    public function store(RegisterRequest $request) {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->assignRole('shop representative');

        return redirect()->route('admin.create')->with('success', '代表者が作成されました');
    }

    public function getUsers()
    {
        $users = User::paginate(10);

        return view('admin.user_list', compact('users'));
    }
}
