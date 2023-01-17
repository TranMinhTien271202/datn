<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
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
        switch($this->method()):
            case 'POST':
                switch($currentAction) {
                    
                    case 'postLogin':
                        $rules = [
                            'email' => 'required|email',
                            'password' => 'required'
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
            'email.unique' => 'Email đã tồn tại trong hệ thống. Vui lòng nhập lại !',
            'name.required' => 'Vui lòng nhập tên',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Vui lòng nhập đúng định dạng email',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'repassword.required' => 'Vui lòng nhập lại mật khẩu'
        ];
    }
}
