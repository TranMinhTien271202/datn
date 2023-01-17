<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role ;

class UserController extends Controller
{
    protected $v;
    public function __construct()
    {
        $this->v = [];
    }
    public function index()
    {
        $this->v['title'] = 'Danh sách người dùng';
        $this->v['users'] = User::all();
        return view('admin.user.index',$this->v);
    }

    public function create()
    {
        $this->v['title'] = __('Thêm người dùng');
        $this->v['roles'] = Role::all()->pluck('name');
        return view('admin.user.add',$this->v);
    }

    public function store(UserRequest $request)
    {
        $model = new User();
        $data = $request->input();
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $data['image'] = uploadFiles($request->file('image'),'image/user');
        };
        $data['password'] = Hash::make($request->input('password'));
        $res = $model->create($data);
        $res->assignRole($request->roles);
        if ($res) {
            Session::flash('success',__('messages.add.success'));
        } else {
            Session::flash('success',__('messages.add.failed'));

        }
        return redirect()->route('admin.user.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $this->v['title'] = __('Cập nhật người dùng');
        $this->v['user'] = User::find($id);
        $this->v['roles'] = Role::all()->pluck('name');
        return view('admin.user.edit',$this->v);
    }

    public function update(UserRequest $request, $id)
    {

        $model = User::find($id);
        $data = $request->input();
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $data['image'] = uploadFiles($request->file('image'),'image/user');
        };
        $data['password'] = Hash::make($request->input('password'));
        $model->syncRoles($request->roles);;
        $res = $model->save($data);
        if ($res) {
            Session::flash('success',__('messages.update.success'));
        } else {
            Session::flash('error',__('messages.update.faild'));
        }
        return redirect()->route('admin.user.index');
    }
    public function destroy($id)
    {
        try {
            User::where('id',$id)->delete();
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
