<?php

namespace App\Http\Controllers\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArtistFilterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'categories' => 'required|array',
            'categories.*' => 'string',
            'minPrice' => 'required|numeric|min:0',
            'maxPrice' => 'required|numeric|min:0',
        ];
    }
}
