<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {

        $id = $this->route()->id;
        $rules = [];
        $currentAction = $this->route()->getActionMethod();
        // để lấy phương thức hiện tại
        switch ($this->method()):
            case 'POST':
                switch ($currentAction) {
                    case 'store':
                        $rules = [
                            'name' => 'required',
                            'company_name' => 'required',
                            'email' => 'required|email|unique:companies',
                            'password' => 'required',
                            'tax_code' => 'required|unique:companies',
                            'phone' => 'required|min:10|max:10|unique:companies',
                            'image' => 'image|mimes:jpg,png,jpeg|max:5000'
                        ];
                        break;

                    case 'update':
                        $rules = [
                            'name' => 'required',
                            'company_name' => 'required',
                            'email' => 'required|email|unique:companies,email,' . $id . ',id',
                            'tax_code' => 'required|unique:companies,tax_code,' . $id . ',id',
                            'phone' => 'required|min:10|max:10|unique:companies,phone,' . $id . ',id',
                            'image' => 'image|mimes:jpg,png,jpeg|max:5000'
                        ];
                        break;

                        
                    default:
                        break;
                }
                break;

            default:
                break;
        endswitch;
        return $rules;
    }
    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên',
            'email.required' => 'Vui lòng nhập email',
            'email.unique' => 'Email đã tồn tại trong hệ thống',
            'email.email' => 'Email sai định dạng',
            'company_name.required' => 'Vui lòng nhập tên công ty',
            'company_name.unique' => 'Tên công ty đã tồn tại',
            'tax_code.required' => 'Vui lòng nhập mã số thuế',
            'tax_code.unique' => 'Mã số thuế đã tồn tại trong hệ thống',
            'phone.required' => 'Vui lòng nhập số điện thoại',
            'phone.min' => 'Số điện thoại phải có 10 số',
            'phone.max' => 'Số điện thoại không quá 10 số',
            'phone.unique' => 'Số điện thoại đã tồn tại!',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'image.mimes' => 'Ảnh phải thuộc định dạng jpg, png, jpeg!',
            'image.max' => 'Ảnh nhập không quá 5mb!',
        ];
    }
}
