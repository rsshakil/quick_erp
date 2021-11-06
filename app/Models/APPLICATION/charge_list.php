<?php

namespace App\Models\APPLICATION;

use App\Models\COUNTRY\district;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class charge_list extends Model
{
    use SoftDeletes;
    public function charge_list()
    {
        return $this->belongsTo(charge_package::class);
    }
    public function district()
    {
        return $this->belongsTo(district::class);
    }

}
