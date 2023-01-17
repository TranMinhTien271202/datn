<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PackageRequest extends FormRequest
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
                            'title' => 'required|unique:packages',
                            'coin' => 'required',
                            'amount' => 'required',
                            'expired' => 'required',
                        ];
                        break;

                    case 'update':
                        $rules = [
                            'title' => 'required',
                            'coin' => 'required',
                            'amount' => 'required',
                            'expired' => 'required',
                        ];
                        break;
                        case 'storec':
                            $rules = [
                                'title' => 'required|unique:packages',
                                'coin' => 'required',
                                'amount' => 'required',
                                'expired' => 'required',
                            ];
                            break;
    
                        case 'updatec':
                            $rules = [
                                'title' => 'required',
                                'coin' => 'required',
                                'amount' => 'required',
                                'expired' => 'required',
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
            'title.required' => __('Không được để trống'),
            'title.unique' =>__('Đã tồn tại, mời nhập mới'),
            'coin.required' => __('Không được để trống'),
            'amount.required' => __('Không được để trống'),
            'expired.required' => __('Không được để trống'),
        ];
    }
}
