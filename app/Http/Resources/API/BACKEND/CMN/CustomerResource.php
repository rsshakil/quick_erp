<?php

namespace App\Http\Resources\API\BACKEND\CMN;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
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
            'id'=>$this->id,
            'merchant_id'=>$this->merchant_id,
            'customer_name'=>$this->customer_name,
            'contact_number'=>$this->contact_number,
            'customer_addresses'=>$this->customer_addresses,
            'status'=>$this->status,
        ];
    }
}
