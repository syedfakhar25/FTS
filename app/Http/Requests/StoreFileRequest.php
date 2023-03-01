<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFileRequest extends FormRequest
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
            'file_type' => 'required',
            'title' => 'required_if:file_type,new',
            'tracking_code' => 'required_if:file_type,copy',
            'send_to' => 'required',
            //'attach_files' => 'mimes:jpg,png,docx,pdf,xlsx|max:2048',
            'attach_files.*' => 'mimes:jpg,png,docx,pdf,xlsx|max:2048',
        ];
    }
}
