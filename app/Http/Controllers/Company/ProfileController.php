<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\ProfileRequest;
use App\Models\Company;
use App\Models\Major;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit()
    {
        $data = auth('company')->user();
        $title = "Sửa thông tin";
        $activeRoute = "profile";
        if (is_null($data)) {
            
            return redirect()->route('company.profile');
        }
        $team = [
            50 => '50-100 người',
            100 => '100-150 người',
            200 => '200-250 người',
            300 => '300-350 người',
            500 => '500-1000 người',
        ];
        $workingTime = [
            6 => '6 tiếng',
            7 => '7 tiếng',
            8 => '8 tiếng',
        ];
            return view('company.profile.edit', compact('data', 'team', 'title', 'activeRoute', 'workingTime'));
        
    }

    public function update(ProfileRequest $request)
    {

        $data = auth('company')->user()->id;
        $company = auth('company')->user();
        if (is_null($company)) {
            Session::flash('error', 'Không tồn tại công ty');
            return redirect()->route('company.profile');
        }
        $data = $request->all();
        if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $name = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('images/company', $name, 'public');
        }else{
            $name = $request->logo_old;
        }
        // dd($data);
        $data['logo'] = $name;
        $data['status'] = $company->status;

        $company->update($data);
        Session::flash('success', "Cập nhật thành công");
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function uploadFile($file)
    {
        $fileName = time() . '_' . $file->getClientOriginalName();
        return $file->storeAs('images', $fileName, 'public');
    }
    public function imagePaper(ProfileRequest $request)
    {
        if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $name = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('images/company', $name, 'public');
        }else{
            $name = $request->logo_old;
        }
        $data['logo'] = $name;
        $data['status'] = 0;
    }
}
