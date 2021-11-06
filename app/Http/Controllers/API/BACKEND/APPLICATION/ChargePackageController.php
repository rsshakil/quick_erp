<?php

namespace App\Http\Controllers\API\BACKEND\APPLICATION;

use App\Http\Controllers\Controller;
use App\Models\APPLICATION\charge_list;
use App\Models\APPLICATION\charge_package;
use App\Models\APPLICATION\weight_list;
use Illuminate\Http\Request;
use App\Http\Resources\API\BACKEND\APPLICATION\ChargePackageResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

class ChargePackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $productCategories = ProductCategory::all();
        // $productSubCategories = ProductSubCategory::all();
        // $stalls = Stall::all();
        // return $data = charge_list::with('charge_list')->get();
        // return $data = charge_package::with('weight_lists')->get();
       // print_r()
        // $packages = ChargePackageResource::collection($data);

        // SELECT CONCAT(
        //     '[{"charge_list_id":',charge_list_id,',',
        //     '"district_name":"',d.district_name,'",',
        //     '"charge_rate":"',c.charge_rate,'",',
        //     '"weights":',
        //     '[',
        //     GROUP_CONCAT(
        //     CONCAT(
        //     '{"weight_name":"',w.weight_name,'",',
        //     '"rate":',p.charge,'}'
        //     )  SEPARATOR ',')
        //     ,']}]'
        //     )
        //     FROM charge_packages AS p
        //     INNER JOIN charge_lists AS c ON c.id=p.charge_list_id
        //     INNER JOIN weight_lists AS w ON w.id = p.weight_list_id
        //     INNER JOIN districts AS d ON d.id=c.district_id
        //     GROUP BY charge_list_id,d.district_name,c.charge_rate

        $charge_packages = charge_package::select('charge_packages.id as charge_package_id',
        'charge_packages.charge_list_id','charge_packages.weight_list_id',
        'charge_packages.charge','charge_packages.deleted_at','d.district_name','cl.district_id',
        'cl.charge_rate','wl.weight_name')
        ->join('charge_lists as cl','cl.id','=','charge_packages.charge_list_id')
        ->join('districts as d','d.id','=','cl.district_id')
        ->join('weight_lists as wl','wl.id','charge_packages.weight_list_id')
        ->withTrashed()->get();
        $collect=collect($charge_packages);
        $grouped=$collect->groupBy('charge_list_id');
        $packages=$grouped->values()->all();

        $my_arr=array();

        foreach ($packages as $key => $package) {
            $tmp_arr=array();
            foreach ($package as $key_pack => $pack) {
                if ($key_pack==0) {
                    $tmp_arr['charge_list_id']=$pack->charge_list_id;
                    $tmp_arr['charge_rate']=$pack->charge_rate;
                    $tmp_arr['district_name']=$pack->district_name;
                    $tmp_arr['deleted_at']=$pack->deleted_at;
                    $tmp_arr['district_id']=$pack->district_id;
                }
                $tmp['weight_list_id']=$pack->weight_list_id;
                $tmp['weight_name']=$pack->weight_name;
                $tmp['charge']=$pack->charge;
                $tmp_arr['weights'][]=$tmp;
            }
            $my_arr[]=$tmp_arr;
        }

        $charge_list=charge_list::select('charge_lists.id as charge_list_id',
        'charge_lists.district_id','d.district_name','charge_lists.charge_rate')
        ->join('districts as d','d.id','charge_lists.district_id')
        ->get();

        $weight_lists=weight_list::select('id as weight_list_id','weight_name',DB::raw("'0' as charge"))->get();


        return response()->json(['packages'=>$my_arr,'charge_list'=>$charge_list,'weight_lists'=>$weight_lists]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $charge_list_id=$request->charge_list_id;
        $weights=$request->weights;
        $save_flag=$request->save_flag;
        $package_array=array();
        foreach ($weights as $weight_key => $weight) {
            $tmp['charge_list_id']=$charge_list_id;
            $tmp['weight_list_id']=$weight['weight_list_id'];
            $tmp['charge']=$weight['charge'];
            $package_array[]=$tmp;

        }
        if ($save_flag=="Save") {
            if (charge_package::where('charge_list_id',$charge_list_id)->withTrashed()->exists()) {
                return response()->json(['status'=>0,'message'=>"Charge duplicated please update existing package",'class_name'=>'error','title'=>'Error']);
            }
        }else if($save_flag=="Update"){

        }

        // foreach ($package_array as $key => $value) {
            charge_package::where('charge_list_id',$charge_list_id)->forceDelete();
        // }
        charge_package::insert($package_array);

        return response()->json(['status'=>1,'message'=>"Package listed",'class_name'=>'success','title'=>'Success']);
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($pack)
    {
        $pack=json_decode($pack,true);
        $charge_list_id=$pack['charge_list_id'];
        $deleted_at=$pack['deleted_at'];
        $charge_package_var=charge_package::where('charge_list_id',$charge_list_id);
        $ret_msg='';
        if ($deleted_at==null) {
            $charge_package_var->delete();
            $ret_msg='Charge listed deleted';
            $ret_title='Deleted!';
        }else{
            $charge_package_var->withTrashed()->restore();
            $ret_msg='Charge listed restored';
            $ret_title='Restored!';
        }
        return response()->json(['status'=>1,'message'=>$ret_msg,'class_name'=>'success','title'=>$ret_title]);
    }
}
