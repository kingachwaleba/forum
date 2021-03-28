<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            'title' => 'string|min:10|max:100',
            'message' => 'string|min:50|max:2000',
            'post_image' => 'image|mimes:jpeg,png,jpg,gif|dimensions:max_width=500,max_height=500,min_width=100,min_height=100',
        ];
    }
}
