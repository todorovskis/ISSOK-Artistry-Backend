<?php

namespace App\Http\Controllers\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOfferRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'status' => 'required|string',
            'timeCreated' => 'required|integer',
            'price' => 'required|numeric',
            'categories' => 'required|array',
            'categories.*' => 'string',
            'selectedImageUrl' => 'nullable|url',// Validate that image is a valid URL
            'mode' => 'nullable|string' // Validate that image is a valid URL
        ];
    }
}
