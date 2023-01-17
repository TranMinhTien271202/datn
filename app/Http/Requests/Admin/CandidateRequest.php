<?php

namespace App\Http\Requests\Admin;

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
        $id = $this->route()->id;
        $rules = [];
        $currentAction = $this->route()->getActionMethod();
        // để lấy phương thức hiện tại
        switch($this->method()):
            case 'POST':
                switch($currentAction) {
                    case 'store':
                        $rules = [
                            'name' => 'required',
                            'email' => 'required|email|unique:candidates',
                            'password' => 'required',
                            'phone' => 'required|min:10|unique:candidates|max:10',
                            'image' => 'image|mimes:jpg,png,jpeg|max:5000'
                        ];
                        break;

                        case 'update':
                        $rules = [
                            'name' => 'required',
                            'email' => 'required|email|unique:candidates,email,' . $id . ',id',
                            'phone' => 'required|max:10|unique:candidates,phone,' . $id . ',id',
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

    public function messages() {
        return [
            'name.required' => 'Yêu cầu nhập tên',
            'email.required' => 'Yêu cầu nhập email',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã tồn tại',
            'password.required' => 'Yêu cầu nhập password',
            'phone.required' => 'Yêu cầu nhập số điện thoại',
            'phone.max' => 'Số điện thoại nhỏ hơn 10 số!',
            'phone.min' => 'Số điện thoại lớn hơn 10 số!',
            'phone.digits' => 'Sai định dạng số điện thoại!',
            'phone.unique' => 'Số điện thoại đã tồn tại!',
            'image.image' => "Yêu cầu nhập ảnh",
            'image.mimes' => 'Ảnh phải thuộc định dạng jpg, png, jpeg!',
            'image.max' => 'Ảnh nhập không quá 5mb!',
        ];
    }
}
