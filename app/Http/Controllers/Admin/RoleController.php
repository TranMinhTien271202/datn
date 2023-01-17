<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    protected $v;
    public function __construct()
    {
        $this->v = [];
    }
    public function index()
    {
        $this->v['title'] = __('Danh sách vai trò');
        $this->v['roles'] = Role::paginate(5);
        $this->v['permissions'] = Permission::get();
        $permissionsToArray = $this->v['permissions']->toArray();
        foreach ($this->v['permissions'] as $key => $value) {
            $value->group_name = (explode('-',$value->name)[0]);
        }
        
        $this->v['group'] = array();
            foreach (  $this->v['permissions'] as $value ) {
                $this->v['group'][$value->group_name][] = $value;
            }
        return view('admin.role.index',$this->v);
    }

    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        $rules = [
            'name' => "required | unique:roles",
            'permissions' => "required"
        ];
        $message = [
            'name.required' => __('messages.name.required'),
            'name.unique'=> __('messages.name.unique'),
            'permissions.required'=> __('messages.permissions.required')
        ];
        $validator = Validator::make($request->input(),$rules,$message);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->messages(),
            ]);
        }else{
            $res = Role::create(['name' => $request->input('name')]);
            $res->givePermissionTo($request->permissions);
            return response()->json([
                'status' => true,
                'data' => $res,
                'message' => __('messages.add.success')
            ]);
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
       $data = Role::find($id)->permissions->pluck('id');
       return response()->json([
                'status' => true,
                'data' => $data,
    ]);
    }
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => "required | unique:roles,name,$id",
            'permissions' => "required"
        ];
        $message = [
            'name.required' => __('messages.name.required'),
            'name.unique'=> __('messages.name.unique'),
            'permissions.required'=> __('messages.permissions.required')
        ];
        $validator = Validator::make($request->input(),$rules,$message);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->messages(),
            ]);
        }else{
            $modelRole = Role::find($id);
            $modelRole->update(['name' => $request->input('name')]);
            $modelRole->syncPermissions($request->permissions);
            return response()->json([
                'status' => true,
                'data' => $modelRole,
                'message' => __('messages.add.success')
            ]);
        }
    }
    public function destroy($id)
    {
        try {
            Role::where('id',$id)->delete();
            $success = true;
            $message = __('messages.delete.success');
            } catch (\Throwable $th) {
                throw $th;
                $success =  false;
                $message = __('messages.add.failed');
            }
            return response()->json([
                'success'=> $success,
                'message' =>  $message
            ]);
    }
}
