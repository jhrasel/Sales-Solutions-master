<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class MerchantSettingRequest extends FormRequest
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
        if (\Request::route()->getName() === "client.settings.business.info.update") {

            return [
                'shop_name' => 'required|string|max:255',
                'shop_address' => 'nullable|string|max:255',
                'shop_logo' => 'nullable|image',
                'shop_id' => 'nullable|integer',
                'shop_meta_title' => 'nullable|string',
                'shop_meta_description' => 'nullable|string',
            ];
        }

        if (\Request::route()->getName() === "client.settings.owner.info.update") {

            return [
                'owner_name' => 'required|string|max:255',
                'owner_number' => 'required|string|max:255',
                'owner_email' => 'required|string|max:255',
                'owner_address' => 'nullable|string|max:255',
                'owner_other_info' => 'nullable|string|max:255',
            ];

        }

        if (\Request::route()->getName() === "client.settings.password.security.update") {

            return [
                'old_password' => 'required',
                'new_password' => 'required|min:6|same:password_confirmation',
                'password_confirmation' => 'required|min:6'
            ];

        }

        if (\Request::route()->getName() === "client.settings.website.update") {

            return [
                'cash_on_delivery' => 'nullable|boolean',
                'invoice_id' => 'nullable|integer',
                'custom_domain' => 'nullable|string',
                'shop_name' => 'nullable|string|max:255',
                'shop_address' => 'nullable|string|max:255',
                'website_shop_logo' => 'nullable|image',
                'shop_id' => 'nullable|integer',
                'meta_title' => 'nullable|string',
                'meta_description' => 'nullable|string',
                
            ];

        }
        return [];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            "success" => false,
            "errors" => $validator->errors(),
            "msg" => $validator->messages("*")->first()
        ], 400));
    }
}
