<?php

namespace App\Http\Requests\API\BACKEND\PARCEL;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request as BaseRequest;
class ParcelRequest extends FormRequest
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
            // 'merchant_id'=>'required',
            // 'charge_package_id'=>'required',
            // 'delivery_option_id'=>'required',
            // 'marchent_order_id'=>'required',
            // 'pickup_address'=>'required',
            // 'product_description'=>'required',
            // 'collection_amount'=>'required',
            // 'total_collection'=>'required',
            // 'remark'=>'required'
        ];
    }
}
