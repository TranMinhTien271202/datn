<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
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
        switch ($this->route()->getActionMethod()) {
            case 'store':
                $rules = [
                    'name' => 'required| unique:permissions',
                    'display_name' => 'required',
                ];
                break;
            case 'update':
                $rules = [
                    'name' => 'required| unique:permissions,name,' . $id . ',id',
                    'display_name' => 'required',
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
            'display_name.required' => __('messages.display_name.required'),
            'name.unique' => __('messages.name.unique'),
        ];
    }
}
