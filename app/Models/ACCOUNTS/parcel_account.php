<?php

namespace App\Models\ACCOUNTS;

use App\Models\PARCEL\parcel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class parcel_account extends Model
{
    use SoftDeletes;
    public function parcel(){
        return $this->belongsTo(parcel::class);
    }
}
