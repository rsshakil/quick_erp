<?php

namespace App\Http\Controllers\API\BACKEND\APPLICATION;

use App\Http\Controllers\Controller;
use App\Models\APPLICATION\weight_list;
use Illuminate\Http\Request;

class WeightController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $weight_lists = weight_list::select('weight_lists.id as weight_list_id',
        'weight_lists.weight_name','weight_lists.deleted_at')
        ->withTrashed()->get();
        return response()->json(['weight_lists'=>$weight_lists]);
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
        $weight_name=$request->weight_name;

        if (weight_list::where('weight_name',$weight_name)->exists()) {
            return response()->json(['status'=>0,'message'=>"Weight name duplicated",'class_name'=>'error','title'=>'Error']);
        }
        $weight_array=array(
            'weight_name'=>$weight_name,
        );
        weight_list::insert($weight_array);
        return response()->json(['status'=>1,'message'=>"Weight listed",'class_name'=>'success','title'=>'Success']);
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
        $weight_name=$request->weight_name;
        $weight_array=array(
            'weight_name'=>$weight_name,
        );
        $weight_list=weight_list::where('id',$id)->first();
        if ($weight_list) {
            if ($weight_list->weight_name!=$weight_name) {
                if (weight_list::where('weight_name',$weight_name)->exists()) {
                    return response()->json(['status'=>0,'message'=>"Weight duplicated",'class_name'=>'error','title'=>'Error']);
                }
            }
        }
        weight_list::where('id',$id)->update($weight_array);
        return response()->json(['status'=>1,'message'=>"Weight list updated",'class_name'=>'success','title'=>'Success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($weight)
    {
        $weight=json_decode($weight,true);
        $weight_list_id=$weight['weight_list_id'];
        $deleted_at=$weight['deleted_at'];
        $weight_list_var=weight_list::where('id',$weight_list_id);
        $ret_msg='';
        if ($deleted_at==null) {
            $weight_list_var->delete();
            $ret_msg='Weight list deleted';
            $ret_title='Deleted!';
        }else{
            $weight_list_var->withTrashed()->restore();
            $ret_msg='Weight list restored';
            $ret_title='Restored!';
        }
        return response()->json(['status'=>1,'message'=>$ret_msg,'class_name'=>'success','title'=>$ret_title]);
    }
}
