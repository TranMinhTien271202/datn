<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SeekerProfileRequest extends FormRequest
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
                        case 'update':
                        $rules = [
                            'coin' => 'required',
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
            'coin.required' => __('messages.coin.required'),
        ];
    }
}
