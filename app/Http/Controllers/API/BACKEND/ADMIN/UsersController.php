<?php

namespace App\Http\Controllers\API\BACKEND\ADMIN;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BACKEND\DFLTFUNC\AllUsedFunction;
use App\Models\ADMIN\User;
use App\Models\ADMIN\users_details;
// use Auth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    private $all_used_functions;

    public function __construct()
    {
        $this->middleware('auth:api');
        $this->all_used_functions = new AllUsedFunction();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $title = __('messages.manage_users');
        $active = 'users';
        $users = $this->all_used_functions->allUsersAll();
        $roles = $this->all_used_functions->get_role_custom_field();
        $permissions = $this->all_used_functions->get_permission_custom_field();
        return response()->json(['users'=>$users,'roles'=>$roles,'permissions'=>$permissions,'active'=>$active]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        if (!($validation_name = Validator::make($request->all(), ['name' => 'required|max:50'])->passes())) {
            return response()->json(['status'=>0,'title'=>"Not Created!",'message' =>"name_required", 'class_name' => 'warning']);
        }
        if (!($validation_email = Validator::make($request->all(), ['email' => 'required|min:6|email'])->passes())) {
            return response()->json(['status'=>0,'title'=>"Not Created!",'message' =>"email_required", 'class_name' => 'warning']);
        }
        if (!($validation_pass = Validator::make($request->all(), ['password' => 'required|min:6'])->passes())) {
            return response()->json(['status'=>0,'title'=>"Not Created!",'message' =>"password_required", 'class_name' => 'warning']);
        }

        $name = $request->name;
        $email = $request->email;
        $password = $request->password;
        $phone = $request->phone;
        $roles = $request->roles;
        $permission_id = $request->permissions;

        $hash_password = Hash::make($password);
        $user_exist = User::where('email', $email)->withTrashed()->first();
        if ($user_exist) {
            return response()->json(['status'=>0,'title'=>"Exists!",'message' =>"exists", 'class_name' => 'error']);
        } else {
            $user = new User;
            $user->name = $name;
            $user->email = $email;
            $user->password = $hash_password;
            $user->save();
            $last_user_id = $user->id;
            $user_details = new users_details;
            $user_details->user_id = $last_user_id;
            $user_details->phone = $phone;
            $user_details->save();

            $role = Role::find($roles);
            $user = User::findOrFail($last_user_id);
            $user->syncRoles();
            $user->assignRole($role);
            $user->syncPermissions($permission_id);
            return response()->json(['status'=>1,'title'=>"Created!",'message' =>"created", 'class_name' => 'success','user_id'=>$last_user_id]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // return $request->all();
        $user_id=$request->user_id;
        $auth_id=Auth::User()->id;

        // return response()->json(auth()->user());
        if (!(Validator::make($request->all(), ['f_name' => 'max:20'])->passes())) {
            return response()->json(['title'=>"Error!",'message' =>'fname_required', 'class_name' => 'error']);
        }

        if (!(Validator::make($request->all(), ['l_name' => 'max:20'])->passes())) {
            return response()->json(['title'=>"Error!",'message' =>'lname_required', 'class_name' => 'error']);
        }
        if (!(Validator::make($request->all(), ['name' => 'max:50'])->passes())) {
            return response()->json(['title'=>"Error!",'message' =>'full_name_required', 'class_name' => 'error']);
        }
        if (!(Validator::make($request->all(), ['email' => 'required|min:6|email'])->passes())) {
            return response()->json(['title'=>"Error!",'message' =>'email_required', 'class_name' => 'error']);
        }
        if (!(Validator::make($request->all(), ['phone' => 'max:50'])->passes())) {
            return response()->json(['title'=>"Error!",'message' =>'phone_required', 'class_name' => 'error']);
        }
        if (!(Validator::make($request->all(), ['dob' => 'date'])->passes())) {
            return response()->json(['title'=>"Error!",'message' =>'dob_required', 'class_name' => 'error']);
        }
        // if (!(Validator::make($request->all(), ['image_url' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024'])->passes())) {
        //     return response()->json(['title'=>"Error!",'message' =>__('messages.select_image'), 'class_name' => 'error']);
        // }
        if (!(Validator::make($request->all(), ['zip' => 'max:20'])->passes())) {
            return response()->json(['title'=>"Error!",'message' =>'postal_required', 'class_name' => 'error']);
        }

        if ($user_id != $auth_id) {
            $authUser=User::find($auth_id);
            if (!($authUser->hasPermissionTo('user_update'))) {
                return response()->json(['title'=>"No permission!",'message' =>'no_permission', 'class_name' => 'error']);
            }
        }

        $f_name = $request->f_name;
        $l_name = $request->l_name;
        $name = $request->name;
        $email = $request->email;
        $phone = $request->phone;
        $dob = $request->dob;
        $gender = $request->gender;
        $postal_code = $request->zip;

        $user = User::find($user_id);
        $user_all_data =$this->all_used_functions->userWithDetails($user_id);
        //  User::where('id', $user_id)
        // ->join('users_details','users_details.user_id','=','users.id')->first();

        // $user_all_data = User::where('id', '=', $user_id)->first();
        // $user_details_data = users_details::where('user_id', '=', $user_id)->first();

        $user_email_exist = $user_all_data->email;
        if ($user_email_exist != $email) {
            if (User::where('email', '=', $email)->exists()) {
                return response()->json(['title'=>"Exists!",'message' =>'exists', 'class_name' => 'error']);
            }
        }
        //
        $user->id = $user_id;
        $user->name = $name;
        $user->email = $email;
        $user->save();

        \Log::info('User Saved');
        $file_name = '';
        $file_name_db = $user_all_data->image;
        // return $request->image_url;

        \Log::info('file_name_db=' . $file_name_db);
        if($request->image_url){
            if ($file_name_db != '') {
                $image_exists = $file_name_db;
                $filename = storage_path() . '/app/' . config('const.USER_UPLOAD_IMAGES_PATH') . $image_exists;
                if (file_exists($filename)) {
                    @unlink($filename);
                }
            }
            $file_name = time().'.' . explode('/', explode(':', substr($request->image_url, 0, strpos($request->image_url, ';')))[1])[1];
            \Image::make($request->image_url)->save(storage_path("/app/".config('const.USER_UPLOAD_IMAGES_PATH')).$file_name);
            $request->merge(['image_url' => $file_name]);

        }else{
            $file_name = $file_name_db;
        }
        $update_array = array(
            'first_name' => $f_name,
            'last_name' => $l_name,
            'phone' => $phone,
            'date_of_birth' => $dob,
            'gender' => $gender,
            'postal_code' => $postal_code,
            'image' => $file_name,
        );

        users_details::where('user_id', $user_id)->update($update_array);
        if ($user_id == $auth_id) {
            $user=$this->all_used_functions->userWithDetails($user_id);;
        }else{
            $user=null;
        }
        return response()->json(['title'=>"Updated!",'message' =>'updated', 'class_name' => 'success','user_data'=>$user]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user_info = User::where('id', $id)->first();
        $user_name = $user_info['name'];
        $detail_exist = users_details::where('user_id', $id)->first();
        User::where('id', $id)->delete();
        if ($detail_exist) {
            $image_exists = $detail_exist['image'];
            $filename = public_path() . '/backend/images/users/' . $image_exists;
            if (file_exists($filename)) {
                @unlink($filename);
            }
            users_details::where('user_id', $id)->delete();
        }
        return response()->json(['title'=>"Deleted!",'message' =>'deleted', 'class_name' => 'success']);
    }
    /**
     * A single user details.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    // public function userDetails(Request $request)
    public function userDetails($user_id)
    {
        // return $user_id;
        $users = $this->all_used_functions->userWithDetails($user_id);
        // DB::select("select * from users as u left join users_details as ud on u.id=ud.user_id where u.id='$user_id'");
        return \response()->json(['users'=>$users]);
    }
    /**
 * Change password for an user.
 *
 * @param  Request $request
 * @return A success or fail message return as json formated
 */
public function changePassword(Request $request)
{
    // return $request->all();
    $auth_id = Auth::User()->id;
    $user_id = $request->user_id;
    $password = $request->password;
    $validation = Validator::make($request->all(), [
        'password' => 'required|min:6',
    ]);
    if ($validation->passes()) {
        if ($user_id != $auth_id) {
            $authUser=User::find($auth_id);
            // if (!($authUser->can('change_password'))) {
            if (!($authUser->hasPermissionTo('change_password'))) {
                return response()->json(['title'=>"No permission!",'message' =>'no_permission', 'class_name' => 'error']);
            }
        }
        $hashed_password = Hash::make($password);
        $user = User::find($user_id);
        $user->password = $hashed_password;
        $user->save();
        return response()->json(['title'=>"Updated!",'message' =>'password_changed', 'class_name' => 'success']);
    } else {
        return response()->json(['title'=>"Not Updated!",'message' =>'required', 'class_name' => 'error']);
    }
}

}
