<?php

namespace App\Http\Controllers\API\BACKEND\HUB_USER;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\API\BACKEND\HUB_USER\HubUserResource;
use App\Http\Requests\API\BACKEND\HUB_USER\HubUserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BACKEND\ADMIN\UsersController;
use App\Models\HUB\hub;
use App\Models\HUB\hub_has_user;
use App\Models\ADMIN\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class HubUserController extends Controller
{
    private $request;
    private $status_filter_where=[];
    private $where_array=[];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->request= $request;
        cache()->forget('hubUserList_for_page');
        $data = cache()->remember('hubUserList_for_page',60*60*24,function(){
        $search = $this->request->search;
        $status_filter = $this->request->status_filter;
        if ($search !== 'false') {
        $this->where_array[]=['name',"like","%".$search."%"];
        }
        if ($status_filter !== 'false') {
        $this->status_filter_where[]=['status',"=",$status_filter];
        }
        $dataSorting = $this->request->sorting === 'false'?10:$this->request->sorting;
        return $data = hub_has_user::orderBy('id', 'desc')->withTrashed()->paginate($dataSorting);
        
        });
        $hubs = hub::orderBy('id', 'desc')->withTrashed()->get();
        return HubUserResource::collection($data)->additional([
            'hubs'=>$hubs
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HubUserRequest $request)
    {
        $validated = $request->validated();
        $UsersController=new UsersController();
        $request->request->add(['name' => $request->name]);
        $request->request->add(['roles' => [3]]);
        $request->request->add(['permissions' => []]);
        $user_save_info = $UsersController->store($request);
        $user_save_info = json_decode($user_save_info->getContent(),true);

        if ($user_save_info['status']==0) {
            return $user_save_info;
        }
        if($request->hub_id!=''){
            $hub_user['hub_id']=$request->hub_id; 
        }else{
            $user_id=Auth::User()->id;
            $hubUserInfo = hub_has_user::where('user_id',$user_id)->first();
            $hub_user['hub_id']=$hubUserInfo->hub_id; 
        }
        $hub_user['user_id']=$user_save_info['user_id'];
        $hub_user['role_id']=3;
        $hub_user_id = hub_has_user::insertGetId($hub_user);
        User::where('id',$user_save_info['user_id'])->delete();
        if ($hub_user_id){
            return response()->json([
                'status' => 1,
                'post_data' => $hub_user_id,
                'icon' => 'check',
                'message' => 'Hub user has been created!',
                'class_name'=>'success'
            ]);
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
