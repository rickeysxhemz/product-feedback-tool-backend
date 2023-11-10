<?php

namespace App\Http\Requests\AuthRequests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name'=>'bail|string|required',
            'email'=>'bail|email|required|unique:users,email',
            'username'=>'bail|string|nullable|unique:users,username',
            'phone'=>'bail|string|nullable|max:11',
            'address'=>'bail|string|nullable',
            'profile_photo_path'=>'bail|string|nullable',
            'password'=>'bail|string|required|min:8||max:255|confirmed',
            // 'password_confirmation' => 'bail|required',

        ];
    }
}
