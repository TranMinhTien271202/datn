<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PermissionRequest;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    protected $v;
    public function __construct()
    {
        $this->v = [];
    }
    public function index()
    {
        $this->v['title'] = __('Danh sách quyền');
        $this->v['permissions'] = Permission::orderby('created_at','DESC')->paginate(config('paginate.permission.index'));
        return view('admin.permission.index',$this->v);
    }

    public function create()
    {
        $this->v['title'] = __('Thêm quyền');
        return view('admin.permission.add',$this->v);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => "required | unique:permissions"
        ];
        $message = [
            'name.required' => __('messages.name.required'),
            'name.unique'=> __('messages.name.unique')
        ];
        $validator = Validator::make($request->input(),$rules,$message);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->messages(),
            ]);
        }else{
            $res  = Permission::create(['name' => $request->input('name')]);;
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
        $this->v['title'] = 'Cập nhật quyền';
        $this->v['permission'] = Permission::find($id);
        return view('admin.permission.edit', $this->v);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => "required | unique:permissions,name,$id"
        ];
        $message = [
            'name.required' => __('messages.name.required'),
            'name.unique'=> __('messages.name.unique')
        ];
        $validator = Validator::make($request->input(),$rules,$message);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->messages(),
            ]);
        }else{
            $res  = Permission::find($id)->update(['name'=>$request->input('name')]);
            return response()->json([
                'status' => true,
                'data' => $res,
                'message' => __('messages.add.success')
            ]);
        }
    }

    public function destroy($id)
    { 
        try {
        Permission::where('id',$id)->delete();
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
