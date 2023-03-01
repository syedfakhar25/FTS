<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends FormRequest
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
            'mobile_number' => [
                'required',
                'string',
                'min:7',
                'max:15',
                Rule::unique('users')->ignore($this->user->id)
            ],
            'name'=>'required|string|min:3|max:100',
            'profile_photo' => 'mimes:jpg,png|max:2048'
        ];
    }
}
