<?php

namespace App\Http\Requests\client;

use Illuminate\Foundation\Http\FormRequest;

class Upcv extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return [
            'path_cv' => 'required'
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'path_cv.required' => 'vui lòng chọn file'
        ];
    }
}
