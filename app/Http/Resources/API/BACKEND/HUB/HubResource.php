<?php

namespace App\Http\Resources\API\BACKEND\HUB;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\ADMIN\User;

class HubResource extends JsonResource
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
                'hub_name'=>$this->hub_name,
                'address'=>$this->address,
                'phone'=>$this->phone,
                'facebook'=>$this->facebook,
                'website'=>$this->website,
                'status'=>$this->status,
                'deleted_at'=>$this->deleted_at
        ];
    }
}
