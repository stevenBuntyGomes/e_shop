<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\FinidOutNumberRule;
class CategoryForm extends FormRequest
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
          'category_name' => ['required', 'unique:categories,category_name', new FinidOutNumberRule],
          'category_description' => 'required',
          'category_photo' => 'required|image',
        ];
    }
    public function messages()
    {
      return [
        'category_name.required' => 'Fill the category field',
        'category_name.numeric' => 'The category field must be number',
        'category_description.required' => 'Fill the category description field'
      ];
    }
}
