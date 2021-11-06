<?php

namespace App\Http\Resources\API\BACKEND\HUB_USER;

use Illuminate\Http\Resources\Json\JsonResource;

class HubUserResource extends JsonResource
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
            'hub_id'=>$this->hub_id,
            'role_id'=>$this->role_id,
            'hubinfo'=>$this->hub,
            'hub_name'=>$this->hub->hub_name,
            'userinfo'=>$this->user,
            'name'=>$this->user->name,
            'email'=>$this->user->email,
        ];
    }
}
