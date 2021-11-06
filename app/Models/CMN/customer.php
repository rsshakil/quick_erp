<?php

namespace App\Models\CMN;

use App\Models\PARCEL\parcel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\CMN\customer_address;

class customer extends Model
{
    use SoftDeletes;
    protected $fillable = ['merchant_id'];
    
    public function customer_addresses(){
        return $this->hasMany(customer_address::class);
    }
    // public function parcel()
    // {
    //     return $this->hasOne(parcel::class);
    // }
}
