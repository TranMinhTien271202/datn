<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PackageRequest;
use App\Models\Package;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PackageController extends Controller
{
    private $v;
    public function __construct(){
        $this->v = [];
    }
// candidate
    public function index()
    {
        $this->v['list'] = Package::where('type_account',1)->paginate(9);
        if($key = request()->key);
            $this->v['list'] = Package::where('type_account',1)->where('title','like','%' . $key . '%')->paginate(9);
        $this->v['title'] = "Danh sách gói nạp Ứng viên";
        return view('admin.package.candidate.index', $this->v);
    }
    public function create()
    {
        $this->v['title'] = "Thêm gói nạp Ứng viên";

        return view('admin.package.candidate.add', $this->v);
    }

    public function store(PackageRequest $request)
    {
        $params = [];
        $params['cols'] = $request->post();
        $params['cols']['created_at'] = Carbon::now()->toDateTimeString();
        $params['cols']['updated_at'] = Carbon::now()->toDateTimeString();
        $params['cols']['type_account'] = 1;

        unset($params['cols']['_token']);
        $model = new Package();
        $res = $model->saveAdd($params);
        if($res == null) {
            Session::flash('error', 'Vui lòng nhập dữ liệu!');
            return Redirect()->route('admin.package.candidate.create');
        }
        else if ($res > 0) {
            Session::flash('success', 'Thêm thành công!');
            return Redirect()->route('admin.package.candidate.index');
        }else {
            Session::flash('error', 'Lỗi thêm mới!');
            return Redirect()->route('admin.package.candidate.create');
        }
        
    }

    public function edit($id)
    {
        $this->v['title'] = "Cập nhật Gói nạp Ứng viên";
        $model = new Package();
        $this->v['obj'] = Package::find($id);
        return view('admin.package.candidate.edit', $this->v);
    }

    public function update(PackageRequest $request, $id)
    {
        $method_route = 'admin.package.candidate.edit';
        $params = [];
        $params['cols'] = $request->post();

        // if($request->hasFile('image') && $request->file('image')->isValid()) {
        //     $params['cols']['avatar'] = $this->uploadFile($request->file('image'));
        // }s
        unset($params['cols']['_token']);
        $model = new Package();
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
        Package::where('id', $id)->delete();
        return response()->json(['success'=>'Xóa thành công!']);
    }
    // company
   
    public function indexc()
    {
        $this->v['list'] = Package::where('type_account',0)->paginate(9);
        if($key = request()->key);
            $this->v['list'] = Package::where('type_account',0)->where('title','like','%' . $key . '%')->paginate(9);
        $this->v['title'] = "Danh sách gói nạp Công ty";
        return view('admin.package.company.index', $this->v);
    }
    public function createc()
    {
        $this->v['title'] = "Thêm gói nạp Công ty";

        return view('admin.package.company.add', $this->v);
    }

    public function storec(PackageRequest $request)
    {
        $params = [];
        $params['cols'] = $request->post();
        $params['cols']['created_at'] = Carbon::now()->toDateTimeString();
        $params['cols']['updated_at'] = Carbon::now()->toDateTimeString();
        $params['cols']['type_account'] = 0;

        unset($params['cols']['_token']);
        $model = new Package();
        $res = $model->saveAdd($params);
        if($res == null) {
            Session::flash('error', 'Vui lòng nhập dữ liệu!');
            return Redirect()->route('admin.package.company.createc');
        }
        else if ($res > 0) {
            Session::flash('success', 'Thêm thành công!');
            return Redirect()->route('admin.package.company.indexc');
        }else {
            Session::flash('error', 'Lỗi thêm mới!');
            return Redirect()->route('admin.package.company.createc');
        }
        
    }
    public function editc($id)
    {
        $this->v['title'] = "Cập nhật Gói nạp Công ty";
        $model = new Package();
        $this->v['obj'] = Package::find($id);
        return view('admin.package.company.edit', $this->v);
    }

    public function updatec(PackageRequest $request, $id)
    {
        $method_route = 'admin.package.company.editc';
        $params = [];
        $params['cols'] = $request->post();

        // if($request->hasFile('image') && $request->file('image')->isValid()) {
        //     $params['cols']['avatar'] = $this->uploadFile($request->file('image'));
        // }s
        unset($params['cols']['_token']);
        $model = new Package();
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

    // cập nhật trạng thái
    public function status(Request $request, $id)
    {
        $params = [];
        $params['cols'] = $request->all();
        unset($params['cols']['_token']);
        $val = $params['cols']['status'];
        Package::where('id', $id)->update(['status' => $val]);
        return response()->json(['success' => 'Cập nhật trạng thái thành công!']);
    }

}
