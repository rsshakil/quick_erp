<?php

namespace App\Http\Controllers\API\BACKEND\ADMIN;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BACKEND\DFLTFUNC\AllUsedFunction;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use App\Models\ADMIN\User;

class AssignPermissionModel extends Controller
{
    private $all_used_functions;

    public function __construct()
    {
        $this->middleware('auth:api');
        $this->all_used_functions = new AllUsedFunction();
    }
    /**
     * Show the page where assign permissions to a User.
     * @return \Illuminate\Http\Response
     */
    public function allUsersAndPermissions()
    {
        $users = $this->all_used_functions->allUsers();
        $permissions = $this->all_used_functions->get_permissions();
        return \response()->json(['users'=>$users,'permissions'=>$permissions]);
    }
    /**
     * Get permissions of an user.
     *
     * @param  Request $request
     * @return Permissions list of desired user as JSON
     */
    public function getPermissionModel($id){
        $user_id = $id;
        // if ($user_id == 0) {
        //     return "Not selected";
        // }
        $user = User::find($user_id);
        $permissions_exists = $user->permissions;
        $permission_names =DB::table('model_has_roles as mhr')->select('mhr.*','rhp.*','p.*')
        ->join('role_has_permissions as rhp','mhr.role_id','=','rhp.role_id')
        ->join('permissions as p','p.id','=','rhp.permission_id')
        ->where('mhr.model_id','=',$user_id)
        ->get();
        $permissions = $this->all_used_functions->get_permissions();
        $permissions_exist_id = array();
        foreach ($permissions_exists as $key => $permissions_exist) {
            $permissions_exist_id[] = $permissions_exist->id;
        }
        $datas = array();
        foreach ($permission_names as $key => $permission_name) {
            $datas[] = $permission_name->name;
        }
        $match = array();
        $not_matches = array();
        foreach ($permissions as $key => $permission) {
            if (in_array($permission->name, $datas)) {

                $match[] = $permission;
            } else {
                $not_matches[] = $permission;
            }
        }
        $all_permissions_for_user_array=$this->all_used_functions->allPermissionForUser($user);
        return response()->json([
            'all_permissions_for_user_array'=>$all_permissions_for_user_array,
            'permissions_exist_id' => $permissions_exist_id,
            'not_matches' => $not_matches
            ]);

    }
    // public function allPermissionForUser($user){
    //     $all_permissions_for_user= $user->getAllPermissions();
    //     $all_permissions_for_user_array=array();
    //     foreach ($all_permissions_for_user as $all_permission_for_user) {
    //         $all_permissions_for_user_array[]=$all_permission_for_user->name;
    //     }
    //     return $all_permissions_for_user_array;
    // }
    /**
     * User permission store in database.
     *
     * @param  Request $request
     * @return A json formated success message
     */
    public function assignPermissionToModel(Request $request)
    {
        // return $request->all();
        $user_id = $request->user_id;
        $permission_id = $request->permission;
        $user = User::find($user_id);
        $permission = Permission::all();
        $user->revokePermissionTo($permission);
        $user->syncPermissions($permission_id);
        $all_permissions_for_user_array=$this->all_used_functions->allPermissionForUser($user);
        return response()->json(['title'=>"Assigned!",'message' =>"success", 'class_name' => 'success','all_permissions_for_user_array'=>$all_permissions_for_user_array]);
    }

    public function getPermissionsByRole(Request $request){
        $all_role_id=$request->role_id;
        $permission_array=array();
        $permission_for_role=array();
        foreach ($all_role_id as $key => $role_id) {
            // $role = Role::findById($role_id);
            $role = Role::where('id',$role_id)->first();
            // \Log::info($role->getAllPermissions());
            $permission_array[]=$role->getAllPermissions();
        }
        foreach ($permission_array as $key => $permissions) {
           foreach ($permissions as $key => $permission) {
               $tmp=$permission->id;
               $permission_for_role[]=$tmp;
           }
        }
        return response()->json(['permission_for_role'=>$permission_for_role]);
    }
    public function getPermissionsByUser(Request $request){
        // return $request->all();
        $user_id=$request->user_id;
        $user = User::findOrFail($user_id);
        $all_permissions= $user->getAllPermissions();
        $permission_count=count($all_permissions);
        $permission_name_array=array();
        foreach ($all_permissions as $key => $all_permission) {
            $permission_name_array[]='<button class="btn btn-info btn-sm" style="margin-top:5px;">'.$all_permission->name.'</button>';
        }
        $permission_implode=implode(' ',$permission_name_array);
        return response()->json(['permissions_for_user'=>$permission_implode,'total_permissions'=>$permission_count]);
    }
    /**
     * Assign permissions to a role.
     *
     * @param  int $role_id
     * @param  array $permissions
     * @return revoke previous permission and set new permission
     */
    // public function assignPermissionToRole($role_id, $permissions)
    // {

    //     $role_id = $role_id;
    //     $permission_id = $permissions;
    //     $role = Role::find($role_id);
    //     $permission = Permission::all();
    //     $role->revokePermissionTo($permission);
    //     $role->givePermissionTo($permission_id);
    // }
}
