<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
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
            'title' => 'required|max:255|unique:articles',
            'details' => 'required',
            'price' => 'required|max:6',
            'availableCopies' => 'required|max:5',
            'discount' => 'required|max:2'
            // max means the maximum number of characters
        ];
    }

    public function messages()
    {
        return [
            'title.required' => "title can't be empty",
            'title.max' => "title can't have more than 255 characters including spaces",
            'title.unique' => "title must be unique",

            'details.required' => "Content field can't be empty",

            'price.required' => "Price field can't be empty",
            'price.max' => 'Price must be equal or less than 999,999',

            'availableCopies.required' => "Stock field can't be empty",
            'availableCopies.max' => 'Stock amount must be equal or less than 99,999',

            'discount.required' => "Discount field can't be empty",
            'discount.max' => 'Discount amount must be equal or less than 99'
        ];
    }
}
