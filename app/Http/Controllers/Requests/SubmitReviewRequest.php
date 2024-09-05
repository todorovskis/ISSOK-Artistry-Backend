<?php

namespace App\Http\Controllers\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubmitReviewRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'offerId' => 'required|integer|exists:offers,id',
            'grade' => 'required|numeric|min:0|max:10',
            'timeCreated' => 'required|integer',
            'review' => 'required|string',
            'title' => 'required|string',
        ];
    }
}
