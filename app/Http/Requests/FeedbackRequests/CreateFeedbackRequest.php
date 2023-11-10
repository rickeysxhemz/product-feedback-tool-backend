<?php

namespace App\Http\Requests\FeedbackRequests;

use Illuminate\Foundation\Http\FormRequest;

class CreateFeedbackRequest extends FormRequest
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
            'title'=> 'bail|required|string',
            'description'=> 'bail|required|string',
            'category'=> 'bail|required|string',
        ];
    }
}
