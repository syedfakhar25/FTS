<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMasterFileRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'title' => [
                'required',
                'string',
                'min:3',
                'max:100',
                Rule::unique('departments')->ignore($this->masterfile->id)
            ],
            'short_code' => [
                'required',
                'string',
                'min:2',
                'max:10',
                Rule::unique('departments')->ignore($this->department->id)
            ],
            'department_id' => 'required',
        ];
    }
}
