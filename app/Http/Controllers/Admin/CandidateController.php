<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CandidateRequest;
use App\Models\Candidate;
use App\Models\Feedback;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CandidateController extends Controller
{
    private $v;
    public function __construct()
    {
        $this->v = [];
    }

    public function index()
    {
        $candidate = new Candidate();
        $this->v['list'] = Candidate::paginate(9);
        if ($key = request()->key);
        $this->v['list'] = Candidate::where('name', 'like', '%' . $key . '%')->paginate(9);
        $this->v['title'] = "Danh sách ứng viên";
        $this->v['feed']=Feedback::where('is_candidate',1)->get();
        return view('admin.candidate.index', $this->v);
    }

    public function create()
    {
        $this->v['title'] = "Thêm ứng viên";

        return view('admin.candidate.add', $this->v);
    }

    public function store(CandidateRequest $request)
    {
        $params = [];
        $params['cols'] = $request->post();
        // dd($params['cols']);
        $params['cols']['created_at'] = Carbon::now()->toDateTimeString();
        $params['cols']['updated_at'] = Carbon::now()->toDateTimeString();

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $params['cols']['avatar'] = $this->uploadFile($request->file('image'));
        }
        unset($params['cols']['_token']);
        $model = new Candidate();
        $res = $model->saveAdd($params);
        if ($res == null) {
            Session::flash('error', 'Vui lòng nhập dữ liệu!');
            return Redirect()->route('admin.candidate.create');
        } else if ($res > 0) {
            Session::flash('success', 'Thêm thành công!');
            return Redirect()->route('admin.candidate.index');
        } else {
            Session::flash('error', 'Lỗi thêm mới!');
            return Redirect()->route('admin.candidate.create');
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $this->v['title'] = "Cập nhật ứng viên";
        $model = new Candidate();
        $this->v['obj'] = Candidate::find($id);
        return view('admin.candidate.edit', $this->v);
    }

    public function update(CandidateRequest $request, $id)
    {
        $method_route = 'admin.candidate.edit';
        $params = [];
        $params['cols'] = $request->post();

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $params['cols']['avatar'] = $this->uploadFile($request->file('image'));
        }

        unset($params['cols']['_token']);
        $model = new Candidate();
        $obj = $model->find($id);
        $params['cols']['id'] = $id;
        $res = $model->saveUpdateAdmin($params);
        if ($res == null) {
            Session::flash('success', 'Cập nhật thành công!');
            return Redirect()->route($method_route, ['id' => $id]);
        }
        if ($res == 1) {
            Session::flash('success', 'Cập nhật ' . $obj->name . ' thành công!');
            return Redirect()->route($method_route, ['id' => $id]);
        } else {
            Session::flash('error', 'Lỗi cập nhật!');
            return Redirect()->route($method_route, ['id' => $id]);
        }
    }

    public function destroy($id)
    {
        Candidate::where('id', $id)->delete();
        return response()->json(['success' => 'Xóa thành công!']);
    }

    // up ảnh
    public function uploadFile($file)
    {
        $fileName = time() . '_' . $file->getClientOriginalName();
        return $file->storeAs('images', $fileName, 'public');
    }

    // cập nhật trạng thái
    public function status(Request $request, $id)
    {
        $params = [];
        $params['cols'] = $request->all();
        // dd($params['cols']);
        unset($params['cols']['_token']);
        $val = $params['cols']['status'];
        Candidate::where('id', $id)->update(['status' => $val]);
        return response()->json(['success' => 'Cập nhật trạng thái thành công!']);
    }
}
