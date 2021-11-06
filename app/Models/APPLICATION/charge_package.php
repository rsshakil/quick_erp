<?php

namespace App\Models\APPLICATION;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class charge_package extends Model
{
    use SoftDeletes;
    // public function weight_lists(): MorphTo
    // {
    //     // return $this->hasOne(weight_list::class,'foreign_key', 'local_key');
    //     // return $this->hasOne(weight_list::class,'id','weight_list_id');
    //     return $this->morphTo(weight_list::class);
    // }
    public function charge_list(){
        return $this->belongsTo(charge_list::class);
    }
    public function weight_list(){
        return $this->belongsTo(weight_list::class);
    }
}
