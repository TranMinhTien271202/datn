<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\SkillRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class SkillController extends Controller
{
    //private $v;
    public function __construct(){
        $this->v = [];
    }

    public function index()
    {
        $candidate = new Skill();
        $this->v['list'] = Skill::paginate(9);
        if($key = request()->key);
            $this->v['list'] = Skill::where('name','like','%' . $key . '%')->paginate(9);
        $this->v['title'] = "Danh sách kỹ năng";
        return view('admin.skill.index', $this->v);
    }
    public function create()
    {
        $this->v['title'] = "Thêm kỹ năng";

        return view('admin.skill.add', $this->v);
    }

    public function store(SkillRequest $request)
    {
        $params = [];
        $params['cols'] = $request->post();
        $params['cols']['created_at'] = Carbon::now()->toDateTimeString();
        $params['cols']['updated_at'] = Carbon::now()->toDateTimeString();

        unset($params['cols']['_token']);
        $model = new Skill();
        $res = $model->saveAdd($params);
        if($res == null) {
            Session::flash('error', 'Vui lòng nhập dữ liệu!');
            return Redirect()->route('admin.skill.create');
        }
        else if ($res > 0) {
            Session::flash('success', 'Thêm thành công!');
            return Redirect()->route('admin.skill.index');
        }else {
            Session::flash('error', 'Lỗi thêm mới!');
            return Redirect()->route('admin.skill.create');
        }
        
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $this->v['title'] = "Cập nhật kỹ năng";
        $model = new Skill();
        $this->v['obj'] = Skill::find($id);
        return view('admin.skill.edit', $this->v);
    }

    public function update(SkillRequest $request, $id)
    {
        $method_route = 'admin.skill.edit';
        $params = [];
        $params['cols'] = $request->post();

        if($request->hasFile('image') && $request->file('image')->isValid()) {
            $params['cols']['avatar'] = $this->uploadFile($request->file('image'));
        }

        unset($params['cols']['_token']);
        $model = new Skill();
        $obj = $model->find($id);
        $params['cols']['id'] = $id;
        $res = $model->saveUpdate($params);
        if($res == null) {
            Session::flash('success', 'Cập nhật thành công!');
            return Redirect()->route($method_route, ['id' => $id]);
        }
        if ($res == 1) {
            Session::flash('success', 'Cập nhật '.$obj->name .' thành công!');
            return Redirect()->route($method_route, ['id' => $id]);
        }else {
            Session::flash('error', 'Lỗi cập nhật!');
            return Redirect()->route($method_route, ['id' => $id]);
        }
    }

    public function destroy($id)
    {
        Skill::where('id', $id)->delete();
        return response()->json(['success'=>'Xóa thành công!']);
    }

}
