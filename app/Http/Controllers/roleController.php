<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;


class roleController extends Controller 
{

    public static function middleware(): array
    {
        return [
            ['middleware' => 'permission:view roles', 'only' => ['showRoles']],
            ['middleware' => 'permission:edit roles', 'only' => ['editRole']],
            ['middleware' => 'permission:create roles', 'only' => ['createRole']],
            ['middleware' => 'permission:delete roles', 'only' => ['destroyRoles']],
        ];
    }
    

    //This method will show role page
    public function showRoles(){
        $roles = Role::orderBy('name', 'ASC')->paginate(4);
        return view('roles/list',[
            'roles' =>  $roles
        ]);
    }
    //This method will create role page
    public function createRole(){
        $permissions = Permission::orderBy('name', 'ASC')->get();
        return view('roles/create',[
            'permissions' => $permissions,
        ]);
    }
    //This method will insert role page
    public function storeRole(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required|unique:roles|min:3',
        ]);

        if($validator->passes()) {
           $role = Role::create(['name' => $request->name]);

           if (!empty ($request->permission)){
            foreach ($request->permission as $name){
                $role->givePermissionTo($name);
            }
           }
            return redirect()->route('roles.index')->with('success','Role created successfully.');
        }else{
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }
    //This method will edit role page
    public function editRole($id){
        $role = Role::findorFail($id);
        $hasPermissions = $role->permissions->pluck('name');
        
        $permissions = Permission::orderBy('name', 'ASC')->get();

        return view('roles.edit', [
            'permissions' => $permissions,
            'role' => $role,
            'hasPermissions' => $hasPermissions,
        ]);
    }
    //This method will update role page
    public function updateRoles(Request $request, $id){
        $role = Role::findorFail($id);
        $validator = Validator::make($request->all(),[
            'name' => 'required|min:3|unique:roles,name,'.$id.',id'
        ]);

        if($validator->passes()) {
            $role->name = $request->name;
            $role->save();

            if (!empty ($request->permission)){
                $role->syncPermissions($request->permission);
            }else{
                $role->syncPermissions([]);
            }

            return redirect()->route('roles.index')->with('success','Role Updated successfully.');
        }else{
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }
    //This method will delete role page
    public function destroyRoles(Request $request){
        $id = $request->id;
        $role = Role::find($id);

        if ($role == null){
            session()->flash('error', 'Role not found');
            return response()->json(['status' => false]);
        }

        $role->delete();

        session()->flash('success', 'Role deleted successfully');
        return response()->json(['status' => true]);
    }
}
