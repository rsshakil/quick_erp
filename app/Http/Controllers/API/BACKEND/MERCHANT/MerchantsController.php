<?php

namespace App\Http\Controllers\API\BACKEND\MERCHANT;
use Helper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\API\BACKEND\MERCHANT\MerchantResource;
use App\Http\Requests\API\BACKEND\MERCHANT\MerchantsRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BACKEND\ADMIN\UsersController;
use App\Models\MERCHANT\merchant;
use App\Models\COUNTRY\area;
use App\Models\COUNTRY\thana;
use App\Models\COUNTRY\district;
use App\Models\ADMIN\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MerchantsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $request;
    private $status_filter_where=[];
    private $where_array=[];
    public function index(Request $request){
        $this->request= $request;
        cache()->forget('merchantList_for_page');
        $data = cache()->remember('merchantList_for_page',60*60*24,function(){
         $search = $this->request->search;
         $status_filter = $this->request->status_filter;
         if ($search !== 'false') {
            $this->where_array[]=['company_name',"like","%".$search."%"];
         }
         if ($status_filter !== 'false') {
            $this->status_filter_where[]=['status',"=",$status_filter];
         }
        $dataSorting = $this->request->sorting === 'false'?10:$this->request->sorting;
       return $data = merchant::where($this->status_filter_where)->orWhere($this->where_array)->orderBy('id', 'desc')->withTrashed()->paginate($dataSorting);
        //return $data;

        //  $dataSorting = $this->request->sorting == 'false'?10:$this->request->sorting;
        //  return $data =$search == 'false'?merchant::orderBy('id', 'desc')->withTrashed()->paginate($dataSorting):merchant::where(function($query) use($search){
        //      $query->orWhere('status', 'LIKE', "%{$search}%");
        //      //$query->orWhere('status', 'LIKE', "%{$search}%");

        //     })->orderBy('id', 'desc')->withTrashed()->paginate($dataSorting);
        });
        $merchant = merchant::get();
     return MerchantResource::collection($data)->additional([
        'merchants'=> $merchant,
     ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MerchantsRequest $request)
    {
        DB::beginTransaction();

        try {
            $validated = $request->validated();

        $UsersController=new UsersController();
        $request->request->add(['name' => $request->merchant_name]);
        $request->request->add(['roles' => [2]]);
        $request->request->add(['permissions' => []]);
        // return $request->all();
        $user_save_info = $UsersController->store($request);
        $user_save_info = json_decode($user_save_info->getContent(),true);

        if ($user_save_info['status']==0) {
            return $user_save_info;
        }
        // return $user_save_info;
        // return $user_save_info['user_id'];
        // $user = User::create([
        //     'name' => $request->merchant_name,
        //     'email' => $request->email,
        //     'password' => Hash::make($request->password)
        // ]);

        $data_merchant = $request->except([
        'nid',
        'tin',
        'merchant_name',
        'name',
        'permissions',
        'roles',
        'email',
        'password',
        'trade_license',
        'image']);
        $data_merchant['image']= Helper::imgProcess($request,'image','image', '', 'images/merchant', 'store', merchant::class);
        $data_merchant['nid']=Helper::imgProcess($request,'nid','nid', '', 'images/merchant', 'store', merchant::class);
        $data_merchant['tin']=Helper::imgProcess($request,'tin','tin', '', 'images/merchant', 'store', merchant::class);
        $data_merchant['trade_license']=Helper::imgProcess($request,'trade_license','trade_license', '', 'images/merchant', 'store', merchant::class);
      // $data_merchant['image']=$image_img;
        $data_merchant['user_id']=$user_save_info['user_id'];
        // return $data_merchant;
        $merchant_id = merchant::insertGetId($data_merchant);
        User::where('id',$user_save_info['user_id'])->delete();
        merchant::where('id',$merchant_id)->delete();

        DB::commit();
        return response()->json([
            'status' => 1,
            'post_data' => $data_merchant,
            'icon' => 'check',
            'message' => 'merchant has been created!',
            'class_name'=>'success'
        ]);
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 0,
                'post_data' => $data_merchant,
                'icon' => 'check',
                'message' => 'merchant has not been created!',
                'class_name'=>'error'
            ]);
            // something went wrong
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
        $data = merchant::withTrashed()->find($id);
        $area=area::withTrashed()->get();
        $thana=thana::withTrashed()->get();
        $district=district::withTrashed()->get();
        $User=User::withTrashed()->get();
//         return  MerchantResource::collection($data)->additional([
//
//         ]);
return (new MerchantResource($data))->additional([
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
        // $user = User::create([
        //     'name' => $request->merchant_name,
        //     'email' => $request->email,
        //     'password' => Hash::make($request->password)
        // ]);

        $data_merchant = $request->except([
        'nid',
        'tin',
        'merchant_name',
        'email',
        'password',
        'phone',
        'trade_license',
        'image']);
        $data_merchant['image'] = Helper::imgProcess($request,'image','image', $id, 'images/merchant', 'update', merchant::class);
        $data_merchant['nid']= Helper::imgProcess($request,'nid','nid', $id, 'images/merchant', 'update', merchant::class);
        $data_merchant['tin']= Helper::imgProcess($request,'tin','tin', $id, 'images/merchant', 'update', merchant::class);
        $data_merchant['trade_license']= Helper::imgProcess($request,'trade_license','trade_license', $id, 'images/merchant', 'update', merchant::class);
      // $data_merchant['image']=$image_img;
        //$data_merchant['user_id']=$user->id;

        $merchant = merchant::find($id)->update($data_merchant);

        if ($merchant){
            return response()->json([
                'status' => 1,
                'post_data' => $data_merchant,
                'icon' => 'check',
                'message' => 'merchant has been updated!',
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
    public function destroy($id, Request $request)
    {
        // return $id;
        // return $request->all();
        $merchant_info=merchant::select('user_id','deleted_at')->where('id',$id)->withTrashed()->first();
        $user_id=$merchant_info->user_id;
        $deleted_at=$merchant_info->deleted_at;

        $msg_var='';
        $ret_status=1;
        $class_name='success';
        $merchant_var=merchant::where('id', $id);
        $user_var=User::where('id', $user_id);
        if($request->optional_id === 'undefined'){
            DB::beginTransaction();

            try {
                if ($deleted_at==null) {
                    merchant::find($id)->withTrashed()->update(['status'=>'rejected']);
                    $merchant_var->delete();
                    $user_var->delete();
                    $msg_var='Deleted';
                }else{
                    $merchant_var->withTrashed()->restore();
                    $user_var->withTrashed()->restore();
                    $msg_var='Restored';
                    merchant::find($id)->withTrashed()->update(['status'=>'active']);
                }
                DB::commit();
                // all good
            } catch (\Exception $e) {
                DB::rollback();
                $msg_var='Not Delete or Restored';
                // something went wrong
            }
        }else{
            // return $request->all();
            $status=$request->status==null?'pending':$request->status;
            DB::beginTransaction();
            try {
                if ($status=='active') {
                    User::where('id',$user_id)->withTrashed()->restore();
                    merchant::where('id',$id)->withTrashed()->update(['status'=>$status]);
                    $aaa=merchant::where('id',$id)->withTrashed()->restore();
                }elseif($status=='pending' || $status=='rejected'){
                    User::where('id',$user_id)->delete();
                    merchant::where('id',$id)->withTrashed()->update(['status'=>$status]);
                    $aaa=merchant::where('id',$id)->delete();
                }
                $msg_var='merchant has been updated!';
                DB::commit();
                // all good
            } catch (\Exception $e) {
                DB::rollback();
                $msg_var='merchant has not been updated!';
                $ret_status=0;
                $class_name='error';
                // something went wrong
            }
        }
        return response()->json(['status' => $ret_status, 'class_name'=>$class_name, 'message' => $msg_var, 'data_count' => $merchant_var->withTrashed()->count()]);

        // $delete = merchant::find($id)->delete();
        // if($delete){
        //     return response()->json([
        //         'status'  => 'danger',
        //         'message' =>'Merchant has been delete',
        //         'icon'    => 'times',
        //     ]);
        // }
    }
}
