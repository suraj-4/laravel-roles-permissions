<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class permissionController extends Controller 
{

    public static function middleware(): array
    {
        return [
            ['middleware' => 'permission:view permissions', 'only' => ['showPermissionPage']],
            ['middleware' => 'permission:edit permissions', 'only' => ['permissionEdit']],
            ['middleware' => 'permission:create permissions', 'only' => ['permissionCreate']],
            ['middleware' => 'permission:delete permissions', 'only' => ['permissionDestroy']],
        ];
    }

    //This method will show permission page
    public function showPermissionPage(){
        $permissions = Permission::orderby('created_at', 'asc')->paginate(4);
        return view('permissions.list',['permissions' => $permissions]);
    }

    //This method will create permission page
    public function permissionCreate(){
        return view('permissions.create');
    }

    //This method will insert permission page
    public function permissionStore(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required|unique:permissions|min:3',
        ]);

        if($validator->passes()) {
            Permission::create(['name' => $request->name]);
            return redirect()->route('permissions.index')->with('success','Permission created successfully.');
        }else{
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    //This method will edit permission page
    public function permissionEdit($id){
        $permission = Permission::findorFail($id);
        return view('permissions.edit', ['permission' => $permission]);
    }

    //This method will update permission page
    public function permissionUpdate(Request $request, $id){
        $permission = Permission::findorFail($id);

        $validator = Validator::make($request->all(),[
            'name' => 'required|min:3|unique:permissions,name,'.$id.',id'
        ]);

        if($validator->passes()) {
            $permission->name = $request->name;
            $permission->save();
            return redirect()->route('permissions.index')->with('success','Permission Updated successfully.');
        }else{
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    //This method will delete permission page
    public function permissionDestroy(Request $request){
        $id = $request->id;
        $permission = Permission::find($id);

        if ($permission == null){
            session()->flash('error', 'Permission not found');
            // return response()->json(['error' => 'Permission not found.'], 404);
            return response()->json(['status' => false]);
        }

        $permission->delete();

        session()->flash('success', 'Permission deleted Successfully');
        return response()->json(['status' => true]);
        
    }
}
