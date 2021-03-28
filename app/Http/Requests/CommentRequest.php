<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
            'message' => 'string|min:10|max:500',
            'comment_image' => 'image|mimes:jpeg,png,jpg,gif|dimensions:max_width=300,max_height=400,min_width=50,min_height=50',
        ];
    }
}
