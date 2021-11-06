<?php

namespace App\Http\Controllers\API\BACKEND\MERCHANT;
use App\Http\Resources\API\BACKEND\MERCHANT\MerchantResource;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BACKEND\ADMIN\UsersController;
use App\Models\MERCHANT\merchant;
use App\Models\COUNTRY\area;
use App\Models\COUNTRY\thana;
use App\Models\COUNTRY\district;
use App\Models\ADMIN\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MerchantController extends Controller
{
    private $request;
    public function index(Request $request){
        $this->request= $request;
        // return user::with('merchant')->get();
        cache()->forget('merchantList_for_page');
        $data = cache()->remember('merchantList_for_page',60*60*24,function(){
         $search = $this->request->search;
         $dataSorting = $this->request->sorting == 'false'?10:$this->request->sorting;
         return $data =$search == 'false'?merchant::orderBy('id', 'desc')->paginate($dataSorting):merchant::where(function($query) use($search){
             $query->orWhere('status', 'LIKE', "%{$search}%");
             //$query->orWhere('status', 'LIKE', "%{$search}%");

            })->orderBy('id', 'desc')->paginate($dataSorting);
        });
     return MerchantResource::collection($data);
    }
    public function getAllMerchant(Request $request){
        $status=$request->status;
        $district_id=$request->district_id;
        // return Auth::user()->id;
        $all_merchants_query=merchant::select(
        'a.area_name','au.name as merchant_name','au.email','merchants.id as merchant_id',
        'merchants.user_id','merchants.company_name','merchants.deleted_at','merchants.status'
        // 'd.district_name','t.thana_name',
        // 'merchants.full_address', 'merchants.business_address',
        // 'merchants.facebook','merchants.website','merchants.nid',
        // 'merchants.trade_license','merchants.tin',
        )
        ->join('districts as d','d.id','=','merchants.district_id')
        ->join('thanas as t','t.id','=','merchants.thana_id')
        ->join('areas as a','a.id','=','merchants.area_id')
        ->join('users as au','au.id','=','merchants.user_id')
        ->withTrashed();
        if ($status!='*') {
            $all_merchants_query=$all_merchants_query->where('merchants.status',$status);
        }
        if ($district_id!='*') {
            $all_merchants_query=$all_merchants_query->where('merchants.district_id',$district_id);
        }

        $all_merchants=$all_merchants_query->get();
        return response()->json(['merchants'=>$all_merchants]);
    }
    public function addMerchant(Request $request){
        // return $request->all();
        $merchant_id=$request->merchant_id;
        $company_name=$request->company_name;
        // $image=$request->image;
        $full_address=$request->full_address;
        $business_address=$request->business_address;
        $district=$request->district;
        $thana=$request->thana;
        $area=$request->area;
        $facebook=$request->facebook;
        $website=$request->website;
        $bank_name=$request->bank_name;
        $account_holder_name=$request->account_holder_name;
        $account_number=$request->account_number;
        $bkash_number=$request->bkash_number;
        $nagad_number=$request->nagad_number;
        $rocket_number=$request->rocket_number;
        $nid=$request->nid;
        $trade_license=$request->trade_license;
        $tin=$request->tin;

        $UsersController=new UsersController();
        $request->request->add(['roles' => [2]]);
        $request->request->add(['permissions' => []]);
        $user_save_info = $UsersController->store($request);
        $user_save_info = json_decode($user_save_info->getContent(),true);

        if ($user_save_info['status']==0) {
            return $user_save_info;
        }
        $merchant_array=array(
            'district_id'=> $district['district_id'],
            'thana_id'=> $thana['thana_id'],
            'area_id'=> $area['area_id'],
            'user_id'=> $user_save_info['user_id'],
            'company_name'=> $company_name,
            'full_address'=> $full_address,
            'business_address'=> $business_address,
            'facebook'=> $facebook,
            'website'=> $website,
            'bank_name'=> $bank_name,
            'account_holder_name'=> $account_holder_name,
            'account_number'=> $account_number,
            'bkash_number'=> $bkash_number,
            'nagad_number'=> $nagad_number,
            'rocket_number'=> $rocket_number,
            'nid'=> $nid,
            'trade_license'=> $trade_license,
            'tin'=> $tin,
        );
        merchant::insert($merchant_array);
        User::where('id',$user_save_info['user_id'])->delete();
        return response()->json(['status'=>1,'title'=>"Created!",'message' =>"Created", 'class_name' => 'success']);
        // return response()->json(['status'=>1,'message'=>'Success']);


    }
    public function changeMerchantStatus(Request $request){
        // return $request->all();
        $merchant_id=$request->merchant_id;
        $user_id=$request->user_id;
        $status=$request->changed_status;
        if ($status=='active') {
            User::where('id',$user_id)->withTrashed()->restore();
        }elseif($status=='pending' || $status=='rejected'){
            User::where('id',$user_id)->delete();
        }
        merchant::where('id',$merchant_id)->update(['status'=>$status]);
        return response()->json([
            'status'=>1,
            'message'=>"Success",
        ]);
    }
    public function merchantDeleteRetrive(Request $request){
        // return $request->all();
        $merchant_id=$request->merchant_id;
        $user_id=$request->user_id;
        $deleted_at=$request->deleted_at;

        $merchant_var=merchant::where('id', $merchant_id);
        $user_var=User::where('id', $user_id);
        if ($deleted_at===null) {
            $merchant_var->delete();
            $user_var->delete();
        }else{
            $merchant_var->withTrashed()->restore();
            $user_var->withTrashed()->restore();
        }
        return response()->json(['status' => 1, 'message' => 'Success', 'data_count' => $merchant_var->withTrashed()->count()]);
    }
    public function getSingleMerchant(Request $request){
        // return $request->all();
        $merchant_id=$request->merchant_id;
        $merchant=merchant::select(
            'merchants.area_id','a.area_name','merchants.id as merchant_id',
            'merchants.user_id','au.name','au.email','aud.phone','merchants.company_name',
            'merchants.deleted_at','merchants.status',
            'merchants.district_id','d.district_name','merchants.thana_id','t.thana_name',
            'merchants.full_address', 'merchants.business_address',
            'merchants.facebook','merchants.website','merchants.bank_name',
            'merchants.account_holder_name','merchants.account_number',
            'merchants.bkash_number','merchants.nagad_number','merchants.rocket_number',
            'merchants.nid','merchants.trade_license','merchants.tin'
            )

            ->join('districts as d','d.id','=','merchants.district_id')
            ->join('thanas as t','t.id','=','merchants.thana_id')
            ->join('areas as a','a.id','=','merchants.area_id')
            ->join('users as au','au.id','=','merchants.user_id')
            ->join('users_details as aud','aud.user_id','=','au.id')
            ->where('merchants.id',$merchant_id)
            ->withTrashed()
            ->first();
            $thanas=thana::select('id as thana_id','thana_name','thana_distance')
            ->where('district_id',$merchant->district_id)
            ->get();
            $areas=area::select('id as area_id','area_name','area_distance')
            ->where('thana_id',$merchant->thana_id)
            ->get();
            $merchant->password=null;
            $merchant->thanas=$thanas;
            $merchant->areas=$areas;
            $merchant->district=array('district_id'=>$merchant->district_id,'district_name'=>$merchant->district_name);
            $merchant->thana=array('thana_id'=>$merchant->thana_id,'thana_name'=>$merchant->thana_name);
            $merchant->area=array('area_id'=>$merchant->area_id,'area_name'=>$merchant->area_name);
            return response()->json(['merchant'=>$merchant]);
    }
    public function show($id)
    {
        $data = merchant::find($id);
        $area=area::all();
        $thana=thana::all();
        $district=district::all();
        $User=User::all();
//         return  MerchantResource::collection($data)->additional([
// 'area'=>$area,
// 'thana'=>$thana,
// 'district'=>$district,
// 'User'=>$User,
//         ]);
return new MerchantResource($data);
    }
    public function updateMerchant(Request $request){
        return $request->all();
    }
}
