<?php

namespace App\Http\Resources\API\BACKEND\MERCHANT;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\ADMIN\User;

class MerchantResource extends JsonResource
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
                'district_id'=>$this->district_id,
                'thana_id'=>$this->thana_id,
                'area_id'=>$this->area_id,
                'user_id'=>$this->user_id,
                'districtInfo'=>$this->district,
                'thanaInfo'=>$this->thana,
                'areaInfo'=>$this->area,
                'userInfo'=>$this->user,
                'district_name'=>$this->district->district_name,
                'thana_name'=>$this->thana->thana_name,
                'area_name'=>$this->area->area_name,
                'email'=>$this->user->email,
                'merchant_name'=>$this->user->name,
                'company_name'=>$this->company_name,
                'full_address'=>$this->full_address,
                'business_address'=>$this->business_address,
                'phone'=>$this->phone,
                'facebook'=>$this->facebook,
                'website'=>$this->website,
                'bank_name'=>$this->bank_name,
                'account_holder_name'=>$this->account_holder_name,
                'account_number'=>$this->account_number,
                'bkash_number'=>$this->bkash_number,
                'nagad_number'=>$this->nagad_number,
                'rocket_number'=>$this->rocket_number,
                'status'=>$this->status,
                'deleted_at'=>$this->deleted_at
        ];
    }
}
