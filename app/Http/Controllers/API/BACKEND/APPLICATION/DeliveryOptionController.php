<?php

namespace App\Http\Controllers\API\BACKEND\APPLICATION;

use App\Http\Controllers\Controller;
use App\Models\APPLICATION\delivery_option;
use Illuminate\Http\Request;

class DeliveryOptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $options = delivery_option::select('id as option_id',
        'option_name','option_rate','deleted_at')
        ->withTrashed()->get();
        return response()->json(['options'=>$options]);
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
        $option_name=$request->option_name;
        $option_rate=$request->option_rate;

        if (delivery_option::where('option_name',$option_name)->exists()) {
            return response()->json(['status'=>0,'message'=>"Option name duplicated",'class_name'=>'error','title'=>'Error']);
        }
        $option_array=array(
            'option_name'=>$option_name,
            'option_rate'=>$option_rate,
        );
        delivery_option::insert($option_array);
        return response()->json(['status'=>1,'message'=>"Option listed",'class_name'=>'success','title'=>'Success']);
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
        $option_name=$request->option_name;
        $option_rate=$request->option_rate;
        $option_array=array(
            'option_name'=>$option_name,
            'option_rate'=>$option_rate,
        );
        $option_list=delivery_option::where('id',$id)->first();
        if ($option_list) {
            if ($option_list->option_name!=$option_name) {
                if (delivery_option::where('option_name',$option_name)->exists()) {
                    return response()->json(['status'=>0,'message'=>"Option duplicated",'class_name'=>'error','title'=>'Error']);
                }
            }
        }
        delivery_option::where('id',$id)->update($option_array);
        return response()->json(['status'=>1,'message'=>"Weight list updated",'class_name'=>'success','title'=>'Success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($option)
    {
        $option=json_decode($option,true);
        $option_id=$option['option_id'];
        $deleted_at=$option['deleted_at'];
        $option_list_var=delivery_option::where('id',$option_id);
        $ret_msg='';
        if ($deleted_at==null) {
            $option_list_var->delete();
            $ret_msg='Option list deleted';
            $ret_title='Deleted!';
        }else{
            $option_list_var->withTrashed()->restore();
            $ret_msg='Option list restored';
            $ret_title='Restored!';
        }
        return response()->json(['status'=>1,'message'=>$ret_msg,'class_name'=>'success','title'=>$ret_title]);
    }
}
