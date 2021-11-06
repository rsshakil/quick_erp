<?php

namespace App\Http\Resources\API\BACKEND\APPLICATION;

use App\Models\APPLICATION\charge_list;
use App\Models\APPLICATION\weight_list;
use Illuminate\Http\Resources\Json\JsonResource;

class ChargePackageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'charge_list_id'=> $this->charge_list_id,
            'weight_list_id'=> $this->weight_list_id,
            'status'=> $this->status,
            'charge'=> $this->charge,
            'chargeList'=>charge_list::where('id', $this->charge_list_id)->first(),
            'weights'=>weight_list::where('id', $this->weight_list_id)->get(),

        ];

    }
}
