<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ImagePaperController extends Controller
{
    public function index()
    {
        $data = auth('company')->user();
        $title = "Sửa thông tin";
        $activeRoute = "image-paper";
        return view('company.image-paper.edit', compact('data', 'title', 'activeRoute'));
    }
    public function update(Request $request)
    {
        $data = auth('company')->user()->id;
        $company = Company::find(auth('company')->user()->id);
        if ($request->hasFile('image_paper')) {
            $image = $request->file('image_paper');
            $name = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('images/image_paper', $name, 'public');
        }else{
            $name = $request->image_paper;
        }
        $data = $request->all();
        $data['image_paper'] = $name;
        $data['status'] = 0;
        $company->update($data);
        Session::flash('message', trans('system.success'));
        Session::flash('alert-class', 'success');
        return redirect()->back();
    }
}
