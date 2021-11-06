<?php

namespace App\Models\HUB;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\COUNTRY\area;
use App\Models\COUNTRY\thana;
use App\Models\COUNTRY\district;
use App\Models\ADMIN\User;

class hub extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'address',
        'hub_name',
        'facebook',
        'phone',
        'website'
        ];
    public function district(){
        return $this->belongsTo(district::class);
    }
    public function thana(){
        return $this->belongsTo(thana::class);
    }
    public function area(){
        return $this->belongsTo(area::class);
    }
    public function user(){
        return $this->belongsTo(User::class)->withTrashed();
    }
}
