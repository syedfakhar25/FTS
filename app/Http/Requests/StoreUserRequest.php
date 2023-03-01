<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
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
            'mobile_number' => 'required|string|unique:users|min:7|max:15',
            'name'=>'required|string|min:3|max:100',
            'profile_photo' => 'mimes:jpg,png|max:2048',
            'password' => [
                'required',
                Password::defaults(),
            ]
        ];
    }
}
