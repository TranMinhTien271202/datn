<?php

namespace App\Http\Requests\Admin;

use App\Rules\NumberPhone;
use Illuminate\Foundation\Http\FormRequest;
// use Illuminate\Support\Facades\Lang;

class UserRequest extends FormRequest
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
        $id = $this->route()->user;
        $rules = [];
        switch ($this->route()->getActionMethod()) {
            case 'store':
                $rules = [
                    'name' => 'required',
                    'email' => 'required|email|unique:users',
                    'phone' => ['required', new NumberPhone],
                    'password' => 'required | min:8',
                    're-password' => 'required | same:password',
                    'image' => 'image',
                    'roles' => 'required'
                ];
                break;
            case 'update':
                $rules = [
                    'name' => 'required',
                    'email' => 'required|email | unique:users,email,' . $id,
                    'phone' => ['required', new NumberPhone],
                    'password' => '',
                    're-password' => ' same:password',
                    'image' => 'image',
                    'roles' => 'required'
                ];
                break;
            default:
                break;
        }
        return $rules;
    }
    public function messages()
    {
        return [
            'name.required' => __('messages.name.required'),
            'email.required' => __('messages.email.required'),
            'email.email' => __('messages.email.email'),
            'email.unique' => __('messages.email.unique'),
            'phone.required' => __('messages.phone.required'),
            'phone.min' => __('messages.phone.min'),
            'password.required' => __('messages.password.required'),
            'password.min' => __('messages.password.min'),
            're-password.required' => __('messages.re-password.required'),
            're-password.same' => __('messages.re-password.same'),
            'image.image' => __('messages.image.image'),
            'roles.required' => __('messages.role.required')

        ];
    }
}
