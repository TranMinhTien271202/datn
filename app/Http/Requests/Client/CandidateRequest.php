<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class CandidateRequest extends FormRequest
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
        $rules = [];
        $currentAction = $this->route()->getActionMethod();
        // để lấy phương thức hiện tại
        switch ($this->method()):
            case 'POST':
                $id = $this->route()->id;
                switch ($currentAction) {
                    case 'update':
                        $rules = [
                            'name' => 'required',
                            'email' => 'required|email|unique:candidates,email,' . $id . ',id',
                            'phone' => 'required|max:10|unique:candidates,phone,' . $id . ',id',
                            'image' => 'mimes:jpg,png,jpeg|max:5000'
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

    public function message()
    {
        return [
            'name.required' => 'Vui lòng nhập tên',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Nhập đúng định dạng email VD:email@gmail.com',
            'email.unique' => 'Email đã tồn tại',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'phone.required' => 'Vui lòng nhập số điện thoại',
            'phone.max' => 'Số điện thoại nhỏ hơn 10 số!',
            'phone.digits' => 'Sai định dạng số điện thoại!',
            'phone.unique' => 'Số điện thoại đã tồn tại!',
            'address.required' => 'Vui lòng  nhập địa chỉ',
            'image.mimes' => 'Ảnh phải thuộc định dạng jpg, png, jpeg!',
            'image.max' => 'Ảnh nhập không quá 5mb!',
        ];
    }
}
