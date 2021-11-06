<?php

namespace App\Models\PARCEL;

use App\Models\ACCOUNTS\parcel_account;
use App\Models\APPLICATION\charge_list;
use App\Models\APPLICATION\charge_package;
use App\Models\APPLICATION\delivery_option;
use App\Models\APPLICATION\weight_list;
use App\Models\CMN\customer;
use App\Models\CMN\customer_address;
use App\Models\MERCHANT\merchant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class parcel extends Model
{
    use SoftDeletes;
    protected $fillable = ['customer_address_id'];

    public function merchant(){
        return $this->belongsTo(merchant::class)->withTrashed();
    }
    public function customer_address(){
        return $this->belongsTo(customer_address::class);
    }

    public static function boot(){
        parent::boot();
        static::created(function(){
            cache()->forget('parcelList');
        });
        static::deleted(function(){
            cache()->forget('parcelList');
        });
        static::updated(function(){
            cache()->forget('parcelList');
        });
    }
    public function parcel_account(){
        return $this->hasOne(parcel_account::class);
    }
    public function delivery_option(){
        return $this->belongsTo(delivery_option::class);
    }
    public function charge_package(){
        return $this->belongsTo(charge_package::class);
    }
}
