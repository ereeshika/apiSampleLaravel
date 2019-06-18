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
            'content' => 'required',
            'price' => 'required|max:6',
            'stock' => 'required|max:5',
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

            'content.required' => "Content field can't be empty",

            'price.required' => "Price field can't be empty",
            'price.max' => 'Price must be equal or less than 999,999',

            'stock.required' => "Stock field can't be empty",
            'stock.max' => 'Stock amount must be equal or less than 99,999',

            'discount.required' => "Discount field can't be empty",
            'discount.max' => 'Discount amount must be equal or less than 99'
        ];
    }
}
