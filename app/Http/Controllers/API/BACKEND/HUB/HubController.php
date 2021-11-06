<?php

namespace App\Http\Controllers\API\BACKEND\HUB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Http\Resources\API\BACKEND\HUB\HubResource;
use App\Http\Requests\API\BACKEND\HUB\HubRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BACKEND\ADMIN\UsersController;
use App\Models\HUB\hub;
use App\Models\COUNTRY\area;
use App\Models\COUNTRY\thana;
use App\Models\COUNTRY\district;
use App\Models\ADMIN\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;


class HubController extends Controller
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
        cache()->forget('hubList_for_page');
        $data = cache()->remember('hubList_for_page',60*60*24,function(){
         $search = $this->request->search;
         $status_filter = $this->request->status_filter;
         if ($search !== 'false') {
            $this->where_array[]=['hub_name',"like","%".$search."%"];
         }
         if ($status_filter !== 'false') {
            $this->status_filter_where[]=['status',"=",$status_filter];
         }
        $dataSorting = $this->request->sorting === 'false'?10:$this->request->sorting;
       return $data = hub::where($this->status_filter_where)->orWhere($this->where_array)->orderBy('id', 'desc')->withTrashed()->paginate($dataSorting);
        
        });
        return HubResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HubRequest $request)
    {
        $validated = $request->validated();

       
        $hub_id=hub::insertGetId($request->all());

        if ($hub_id){
            return response()->json([
                'status' => 1,
                'post_data' => $request->all(),
                'icon' => 'check',
                'message' => 'Hub has been created!',
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
        $data = hub::withTrashed()->find($id);
        $area=area::withTrashed()->get();
        $thana=thana::withTrashed()->get();
        $district=district::withTrashed()->get();
        $User=User::withTrashed()->get();

return (new HubResource($data))->additional([
    'area'=>$area,
    'thana'=>$thana,
    'district'=>$district,
    'User'=>$User,
]);
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
        $data= $request->except(['id']);
        $hub = hub::find($id)->update($data);

        if ($hub){
            return response()->json([
                'status' => 1,
                'post_data' => $hub,
                'icon' => 'check',
                'message' => 'HUB has been updated!',
                'class_name'=>'success'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,Request $request)
    {
        if($request->optional_id === 'undefined'){
            $hub = hub::find($id)->delete();
            if ($hub){
                return response()->json([
                    'status' => 1,
                    'post_data' => $hub,
                    'icon' => 'check',
                    'message' => 'HUB has been delete!',
                    'class_name'=>'success'
                ]);
            }
        }else{
            $hub = hub::find($id)->update($request->all());

        if ($hub){
            return response()->json([
                'status' => 1,
                'post_data' => $hub,
                'icon' => 'check',
                'message' => 'HUB has been updated!',
                'class_name'=>'success'
            ]);
        }
        }
    }
}
