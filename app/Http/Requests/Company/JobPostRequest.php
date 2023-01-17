<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class JobPostRequest extends FormRequest
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
                    'title' => 'required',
                    'amount' => 'required',
                    'address' => 'required',
                    'description' => 'required',
                    'requirement' => 'required',
                    'benefits' => 'required',
                    'end_date' => 'required'
                ];
                break;
            case 'update':
                $rules = [
                    'title' => 'required',
                    'amount' => 'required',
                    'address' => 'required',
                    'description' => 'required',
                    'requirement' => 'required',
                    'benefits' => 'required',
                    'skill' => 'required',
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
            'title.required' => 'Vui lòng điền tiêu đề',
            'amount.required' => 'Vui lòng điền số lượng',
            'address.required' => 'Vui lòng điền địa chỉ',
            'description.required' => 'Vui lòng điền mô tả',
            'requirement.required' => 'Vui lòng điền yêu cầu',
            'benefits.required' => 'Vui lòng điền quyền lợi',
            'skill.required' => 'Vui lòng điền kĩ năng',
            'start_date.required' => 'Vui lòng chọn thời gian bắt đầu',
            'end_date.required' => 'Vui lòng chọn thời gian kết thúc',
            
        ];
    }
}
