<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SkillRequest extends FormRequest
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
                            'name' => 'required|unique:skills',
                            'description' => 'required',
                        ];
                        break;

                        case 'update':
                        $rules = [
                            'name' => 'required|unique:skills',
                            'description' => 'required',
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
            'name.required' => __('messages.name.required'),
            'name.unique' => __('messages.name.unique'),
            'description.required' => __('messages.description.required')
        ];
    }
}
