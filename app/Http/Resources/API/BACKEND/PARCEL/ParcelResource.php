<?php

namespace App\Http\Resources\API\BACKEND\PARCEL;

use App\Http\Resources\API\BACKEND\MERCHANT\MerchantResource;
use App\Models\MERCHANT\merchant;
use Illuminate\Http\Resources\Json\JsonResource;

class ParcelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'customer_address_id' => $this->customer_address_id,
            'customer_id' => $this->customer_address->customer_id,
            'customer_name' => $this->customer_address->customer->customer_name,
            'merchant_id'=>$this->merchant_id,
            'merchant_name'=>$this->merchant->user->name,
            'charge_package_id'=>$this->charge_package_id,
            'charge_package'=>$this->charge_package,
            'weight_package'=>$this->charge_package->weight_list,
            'district_name'=>$this->charge_package->charge_list->district->district_name,
            'delivery_charge'=>$this->charge_package->charge_list->charge_rate,
            'weight_name'=>$this->charge_package->weight_list->weight_name,
            'weight_charge'=>$this->charge_package->charge,
            'option_charge'=>(($this->delivery_option->option_rate)*($this->parcel_account->collection_amount))/100,
            'delivery_option_id'=>$this->delivery_option_id,
            'delivery_option'=>$this->delivery_option->option_name,
            'delivery_option_rate'=>$this->delivery_option->option_rate,
            'marchent_order_id'=>$this->marchent_order_id,
            'selected_pickup_address'=>$this->selected_pickup_address,
            'pickup_address'=>$this->pickup_address,
            'product_description'=>$this->product_description,
            'collection_amount'=>$this->parcel_account->collection_amount,
            'charge_amount'=>$this->parcel_account->charge_amount,
            'total_collection'=>$this->parcel_account->total_collection,
            'status'=>$this->status,
            'remark'=>$this->remark,
            'deleted_at'=>$this->deleted_at
        ];
    }
    // merchant::withTrashed()->find($this->merchant_id)
}
