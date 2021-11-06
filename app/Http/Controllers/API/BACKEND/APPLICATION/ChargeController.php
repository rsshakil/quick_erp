<?php

namespace App\Http\Controllers\API\BACKEND\APPLICATION;

use App\Http\Controllers\Controller;
use App\Models\COUNTRY\district;
use App\Models\APPLICATION\charge_list;
use Illuminate\Http\Request;

class ChargeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $charges = charge_list::select('charge_lists.id as charge_list_id','charge_lists.district_id',
        // 'districts.district_name as charge_name','charge_lists.charge_rate')
        // ->join('districts','districts.id','=','charge_lists.district_id')
        // ->get();
        $charge_lists = charge_list::select('charge_lists.id as charge_list_id',
        'charge_lists.district_id','charge_lists.charge_rate','charge_lists.deleted_at')
        ->withTrashed()->get();
        $charges=array();
        foreach ($charge_lists as $key => $charge_list) {
            $district=district::select('id as district_id','district_name')->where('id',$charge_list->district_id)->first();
            $charge_list->district=$district;
            unset($charge_list->district_id);
            $charges[]=$charge_list;
        }

        return response()->json(['charges'=>$charges]);
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
        $charge_rate=$request->charge_rate!=null?$request->charge_rate:0;
        $district_id=($request->district)['district_id'];

        if (charge_list::where('district_id',$district_id)->exists()) {
            return response()->json(['status'=>0,'message'=>"District duplicated",'class_name'=>'error','title'=>'Error']);
        }
        $charge_array=array(
            'district_id'=>$district_id,
            'charge_rate'=>$charge_rate,
        );
        charge_list::insert($charge_array);
        return response()->json(['status'=>1,'message'=>"Charge listed",'class_name'=>'success','title'=>'Success']);
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
        // return $request->all();
        $charge_rate=$request->charge_rate!=null?$request->charge_rate:0;
        $district_id=($request->district)['district_id'];
        $charge_array=array(
            'district_id'=>$district_id,
            'charge_rate'=>$charge_rate,
        );
        $charge_list=charge_list::where('id',$id)->first();
        if ($charge_list->district_id!=$district_id) {
            if (charge_list::where('district_id',$district_id)->exists()) {
                return response()->json(['status'=>0,'message'=>"District duplicated",'class_name'=>'error','title'=>'Error']);
            }
        }
        charge_list::where('id',$id)->update($charge_array);
        return response()->json(['status'=>1,'message'=>"Charge listed updated",'class_name'=>'success','title'=>'Success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($charge)
    {

        $charge=json_decode($charge,true);
        $charge_list_id=$charge['charge_list_id'];
        $deleted_at=$charge['deleted_at'];
        $charge_list_var=charge_list::where('id',$charge_list_id);
        $ret_msg='';
        if ($deleted_at==null) {
            $charge_list_var->delete();
            $ret_msg='Charge listed deleted';
            $ret_title='Deleted!';
        }else{
            $charge_list_var->withTrashed()->restore();
            $ret_msg='Charge listed restored';
            $ret_title='Restored!';
        }
        return response()->json(['status'=>1,'message'=>$ret_msg,'class_name'=>'success','title'=>$ret_title]);
    }
}
