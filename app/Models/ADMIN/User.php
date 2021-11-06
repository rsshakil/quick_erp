<?php

namespace App\Models\ADMIN;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Permission;
use App\Models\ADMIN\users_details;
use App\Models\MERCHANT\merchant;
use Auth;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tymon\JWTAuth\Contracts\JWTSubject;
class User extends Authenticatable implements JWTSubject
{
    use Notifiable,HasRoles, SoftDeletes;
    // use SoftDeletes;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * Get the phone record associated with the user.
     */
    // public function userDetailsRel()
    // {
    //     // return $this->hasOne('App\users_details', 'user_id');
    //     return $this->hasOne('App\users_details', 'user_id', 'id');
    // }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    // protected $guard_name = 'web';
    // protected $guard_name = 'api';

    // public function getFirstNameAttribute()
    // public function getImageAttribute()
    // {
    //     $user_id= Auth::user()->id;
    //     $user_details = users_details::where('user_id', $user_id)->first();
    //     if($user_details){
    //         $image_name = $user_details->image;
    //     } else {
    //         $image_name = null;
    //     }
    //     return $image_name;
    // }
    // For check permission like can in vue
    // public function getAllPermissionsAttribute() {
    //     $permissions = [];
    //       foreach (Permission::all() as $permission) {
    //         if (Auth::user()->can($permission->name)) {
    //           $permissions[] = $permission->name;
    //         }
    //       }
    //     return $permissions;
    //  }
      /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function merchant(){
        return $this->hasOne(merchant::class, 'user_id','id');
    }

}
