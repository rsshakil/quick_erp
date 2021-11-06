<?php

namespace App\Models\APPLICATION;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\APPLICATION\charge_package;
class weight_list extends Model
{
    use SoftDeletes;
    public function charge_package(): BelongsToMany
    {
        return $this->belongsToMany(charge_package::class,'weight_list_id','id');
    }
    // public function charge_package(){
    //     return $this->belongsTo(charge_package::class);
    // }
}
