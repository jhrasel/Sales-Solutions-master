<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Request;

class ProductRequest extends FormRequest
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
        if(Request::route()->getName() === "client.products.store"){
            return [
                'category_id' => 'required_without:category_name|integer',
                'category_name' => 'required_without:category_id|string',
                'product_name' => 'required|string',
                'product_code' => 'required|string',
                'price' => 'required|integer',
                'discount' => 'required|integer',
                'short_description' => 'nullable|string',
                'main_image' => 'required|image|mimes:png,jpg,jpeg|max:2048',
                'other_image' => 'nullable',
                'other_image.*' => 'image|mimes:png,jpg,jpeg|max:2048',
                'status' => 'nullable|boolean',
            ];
        }

        if(Request::route()->getName() === "client.products.update"){
            return [
                'category_id' => 'required|integer',
                'product_name' => 'required|string',
                'price' => 'required|integer',
                'discount' => 'nullable|integer',
                'short_description' => 'nullable|string',
                'main_image' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
                'other_image' => 'nullable|image|array|mimes:png,jpg,jpeg|max:2048',
                'status' => 'nullable|boolean',
            ];
        }

        if(Request::route()->getName() === "client.inventory.update"){
            return [
                'product_id' => 'required|integer',
                'product_name' => 'nullable|string',
                'product_code' => 'nullable|string',
                'selling_price' => 'nullable|integer',
                'main_image' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            ];
        }
        if(Request::route()->getName() === "client.stock.in.update"){
            return [
                'product_id' => 'required|integer',
                'stock_quantity' => 'required|integer',
            ];
        }
        if(Request::route()->getName() === "product.return.update"){
            return [
                'product_id' => 'required|integer',
                'renturn_product_note' => 'nullable|integer',
            ];
        }
        return [];

    }

    public function failedValidation(Validator $validator)
    {
        throw new   HttpResponseException(response()->json(
            [
                'success' => false,
                'msg'  => $validator->errors(),
            ], 400));
    }
}
