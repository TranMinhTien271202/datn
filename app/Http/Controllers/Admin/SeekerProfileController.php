<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SeekerProfileRequest;
use App\Models\Candidate;
use App\Models\SeekerProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SeekerProfileController extends Controller
{
    //
    public function index(){
        $data = SeekerProfile::paginate(9);
        $a=[];
        foreach($data as $k){
            if(in_array($k->candidate_id, $a)){
                continue;
            }else{
                $a[]=$k->candidate_id;
            }
        }
        foreach($a as $b=>$c){
            $can[] = Candidate::where('id',$c)->get();
        }
        $title ='Danh sách CV';
        return view('admin.seekerProfile.index',compact('data','can','title'));
    }

    public function update(SeekerProfileRequest $request, $id)
    {
        $method_route = 'admin.seekerProfile.index';
        $params = [];
        $params['cols'] = $request->post();

        // if($request->hasFile('image') && $request->file('image')->isValid()) {
        //     $params['cols']['avatar'] = $this->uploadFile($request->file('image'));
        // }

        // unset($params['cols']['_token']);
        $model = new SeekerProfile();
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
        SeekerProfile::where('id', $id)->delete();
        return response()->json(['success'=>'Xóa thành công!']);
    }
}