<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class userController extends Controller 
{

    public static function middleware(): array
    {
        return [
            ['middleware' => 'permission:view users', 'only' => ['showUsers']],
            ['middleware' => 'permission:edit users', 'only' => ['editUsers']],
        ];
    }


    /**
     * Display a listing of the resource.
     */
    public function showUsers()
    {
        $users = User::all();
        return view('users.list', [
            'users' => $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createUsers()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeUsers(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editUsers(string $id)
    {
        $user = User::find($id);
        $roles = Role::orderBy('name', 'ASC')->get();
        $hasRole = $user->roles()->pluck('id');
        return view('users.edit', [
            'user' => $user,
            'roles' => $roles,
            'hasRole' => $hasRole,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateUsers(Request $request, string $id)
    {
        $user = User::find($id);
        $validate = Validator::make($request->all(),[
            'name' => 'required|min:5',
            'email' => 'required|email|unique:users,email,'.$id.',id',
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate);
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        $user->syncRoles($request->role);

        return redirect()->route('users.index')->with('success','User updated successfully.');       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyUsers(string $id)
    {
        //
    }
}
