<?php

namespace App\Http\Controllers\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'username' => 'required|string|unique:clients,username',
            'password' => 'required|string|min:6|confirmed',
            'confirmPassword' => 'required_with:password|same:password',
            'age' => 'nullable|integer',
            'name' => 'required|string',
            'country' => 'required|string',
            'profilePicture' => 'required|file|mimes:jpg,jpeg,png|max:2048',
        ];
    }
}
