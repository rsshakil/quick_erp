<?php

namespace App\Models\MERCHANT;

use App\Models\ACCOUNTS\parcel_account;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\COUNTRY\area;
use App\Models\COUNTRY\thana;
use App\Models\COUNTRY\district;
use App\Models\ADMIN\User;

class merchant extends Model
{
    use SoftDeletes;
    protected $fillable = ['company_name',
        'full_address',
        'business_address',
        'facebook',
        'website',
        'bank_name',
        'account_holder_name',
        'account_number',
        'bkash_number',
        'nagad_number',
        'rocket_number'
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

    public static function boot(){
        parent::boot();
        static::created(function(){
            cache()->forget('merchantList_for_page');
        });
        static::deleted(function(){
            cache()->forget('merchantList_for_page');
        });
        static::updated(function(){
            cache()->forget('merchantList_for_page');
        });
    }
}
