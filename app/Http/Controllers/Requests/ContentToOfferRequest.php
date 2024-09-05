<?php

namespace App\Http\Controllers\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContentToOfferRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'content' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'offerId' => 'required|integer|exists:offers,id',
            'artistUsername' => 'required|string',
        ];
    }

}
