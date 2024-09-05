<?php

namespace App\Http\Controllers\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignArtistToOfferRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'artistId' => 'required|integer',
            'offerId' => 'required|integer|exists:offers,id',
        ];
    }
}
