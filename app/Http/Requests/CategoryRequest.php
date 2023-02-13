<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    // public function authorize()
    // {
    //     return false;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if(\Request::route()->getName() === "client.categories.store"){
            return [
                'name' => 'required|string|max:255',
                'parent_id' => 'nullable|integer',
                'category_image' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
                'status' => 'required|integer'
            ];
        }

        if(\Request::route()->getName() === "client.products.update"){
            return [
                'name' => 'required|string|max:255',
                'parent_id' => 'nullable|integer',
                'category_image' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
                'status' => 'required|integer'
            ];
        }

        return [];

    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            "success"=>false,
            "errors"=>$validator->errors(),
            "msg"=>$validator->messages("*")->first()
        ], 400));
    }
}
