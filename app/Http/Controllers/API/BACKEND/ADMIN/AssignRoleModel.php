<?php

namespace App\Http\Controllers\API\BACKEND\ADMIN;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BACKEND\DFLTFUNC\AllUsedFunction;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use App\Models\ADMIN\User;

class AssignRoleModel extends Controller
{
    private $all_used_functions;

    public function __construct()
    {
        $this->middleware('auth:api');
        $this->all_used_functions = new AllUsedFunction();
    }
    /**
     * Assign role to an user.
     *
     * @return \Illuminate\Http\Response
     */
    public function allUsersAndRoles()
    {
        $active = 'assign_role_model';
        $users=$this->all_used_functions->allUsers();
        $roles = $this->all_used_functions->get_role_custom_field();
        return \response()->json(['users'=>$users,'roles'=>$roles,'active'=>$active]);
    }
    /**
     * Get roles for a desired user.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function getRoleById($id)
    {
        $model_data = DB::table('model_has_roles')->select('roles.id as role_id','roles.name as role_name')
        ->join('roles','roles.id','=','model_has_roles.role_id')
            ->where('model_has_roles.model_id', $id)
            ->get();
        return response()->json(['model_data'=>$model_data]);

    }
    /**
     * Assign roles to a user.
     *
     * @param  int $user_id
     * @param  array $roles
     * @return revoke previous roles and set new roles and return a success message
     */
    public function assignModelRole(Request $request)
    {
        $user_id = $request->user_id;
        $roles = $request->roles;
        $role = Role::find($roles);
        $user = User::findOrFail($user_id);
        $user->syncRoles();
        $user->assignRole($role);
        return response()->json(['title'=>"Assigned!",'message' =>"success", 'class_name' => 'success']);
    }

}
