<?php

namespace App\Models\HUB;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ADMIN\User;
use App\Models\HUB\hub;

class hub_has_user extends Model
{
    use SoftDeletes;
    public function user(){
        return $this->belongsTo(User::class)->withTrashed();
    }
    public function hub(){
        return $this->belongsTo(hub::class,'hub_id','id')->withTrashed();
    }
}
