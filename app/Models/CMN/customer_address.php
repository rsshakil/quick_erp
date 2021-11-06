<?php

namespace App\Models\CMN;

use App\Models\APPLICATION\charge_list;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\CMN\customer;

class customer_address extends Model
{
    use SoftDeletes;
    protected $fillable = ['address'];
    public function customer(){
        return $this->belongsTo(customer::class);
    }
    public function district(){
        return $this->belongsTo(charge_list::class);
    }

}
