<?php

namespace App\Http\Controllers\API\BACKEND\CMN;

use App\Http\Controllers\Controller;
use App\Models\PARCEL\parcel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BACKEND\CMN\CmnController;

class HomeController extends Controller
{
    private $CmnController;
    public function __construct(){
        $this->CmnController = new CmnController();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $total_pending_parcels=0;
        $total_parcels=0;
        $total_delivered_parcels=0;
        $total_returned_parcels=0;
        // $pending_parcel_query=parcel::where('status','pending');
        // if (Auth::user()->hasRole(config('const.ADM_ROLE'))) {
        //     $total_pending_parcels=$pending_parcel_query->withTrashed()->count();
        // }else
        if (Auth::user()->hasRole(config('const.MERCHANT_ROLE'))) {
            $merchant_id=$this->CmnController->getMerchantIdByUser(Auth::User()->id);
            $total_pending_parcels=parcel::where('status','pending')->where('merchant_id',$merchant_id)->count();
            $total_parcels=parcel::where('merchant_id',$merchant_id)->count();
            $total_delivered_parcels=parcel::where('status','delivered')->where('merchant_id',$merchant_id)->count();
            $total_returned_parcels=parcel::where('status','returned')->where('merchant_id',$merchant_id)->count();
        }else{
            $total_pending_parcels=parcel::where('status','pending')->withTrashed()->count();
            $total_parcels=parcel::withTrashed()->count();
            $total_delivered_parcels=parcel::where('status','delivered')->withTrashed()->count();
            $total_returned_parcels=parcel::where('status','returned')->withTrashed()->count();
        }
        return response()->json(
            [
                'total_pending_parcels'=>$total_pending_parcels,
                'total_parcels'=>$total_parcels,
                'total_delivered_parcels'=>$total_delivered_parcels,
                'total_returned_parcels'=>$total_returned_parcels
            ]
        );
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
        //
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
