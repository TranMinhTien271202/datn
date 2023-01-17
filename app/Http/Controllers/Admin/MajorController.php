<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Major;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\MajorRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class MajorController extends Controller
{
    public function __construct(){
        $this->v = [];
    }

    public function index()
    {
        $candidate = new Major();
        $this->v['list'] = Major::paginate(9);
        if($key = request()->key);
            $this->v['list'] = Major::where('name','like','%' . $key . '%')->paginate(9);
        $this->v['title'] = "Danh sách chuyên ngành";
        return view('admin.major.index', $this->v);
    }
    public function create()
    {
        $this->v['title'] = "Thêm chuyên ngành";

        return view('admin.major.add', $this->v);
    }

    public function store(Request $request)
    {
        $params = [];
        $params['cols'] = $request->post();
        $params['cols']['created_at'] = Carbon::now()->toDateTimeString();
        $params['cols']['updated_at'] = Carbon::now()->toDateTimeString();

        unset($params['cols']['_token']);
        $model = new Major();
        $res = $model->saveAdd($params);
        if($res == null) {
            Session::flash('error', 'Vui lòng nhập dữ liệu!');
            return Redirect()->route('admin.major.create');
        }
        else if ($res > 0) {
            Session::flash('success', 'Thêm thành công!');
            return Redirect()->route('admin.major.index');
        }else {
            Session::flash('error', 'Lỗi thêm mới!');
            return Redirect()->route('admin.major.create');
        }
        
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $this->v['title'] = "Cập nhật chuyên ngành";
        $model = new Major();
        $this->v['obj'] = Major::find($id);
        return view('admin.major.edit', $this->v);
    }

    public function update(Request $request, $id)
    {
        $method_route = 'admin.major.edit';
       
        $model = Major::find($id);
        $res = $model->update($request->all());
        if($res == null) {
            Session::flash('success', 'Cập nhật thành công!');
            return Redirect()->route($method_route, ['id' => $id]);
        }
        if ($res == 1) {
            Session::flash('success', 'Cập nhật thành công!');
            return Redirect()->route($method_route, ['id' => $id]);
        }else {
            Session::flash('error', 'Lỗi cập nhật!');
            return Redirect()->route($method_route, ['id' => $id]);
        }
    }

    public function destroy($id)
    {
        Major::where('id', $id)->delete();
        return response()->json(['success'=>'Xóa thành công!']);
    }
}
