<?php

namespace App\Http\Controllers\API\BACKEND\PARCEL;

use App\Http\Controllers\API\BACKEND\CMN\CmnController;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\BACKEND\MERCHANT\MerchantResource;
use App\Http\Resources\API\BACKEND\PARCEL\ParcelResource;
use Illuminate\Http\Request;
use App\Models\PARCEL\parcel;
use App\Models\CMN\customer;
use App\Models\CMN\customer_address;

use App\Models\MERCHANT\merchant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\API\BACKEND\PARCEL\ParcelRequest;
use App\Http\Resources\API\BACKEND\CMN\CustomerResource;
use App\Models\ACCOUNTS\parcel_account;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Response;
require_once base_path('vendor/tecnickcom/tcpdf/tcpdf.php');
use setasign\Fpdi\Tcpdf\Fpdi;
use tecnickcom\tcpdf\TCPDF_FONTS;


class ParcelController extends Controller
{
    private $request;
    public $merchant_id;
    private $CmnController;
    private $where_array=[];
    private $where_merchant=[];
    public function __construct(){
        $this->CmnController = new CmnController();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // :AnonymousResourceCollection
    public function index(Request $request)
    {
        $merchants=array();
        $merchant=array();
        $this->request= $request;
        // return $this->request;

        if (Auth::user()->hasRole(config('const.ADM_ROLE'))) {
            $merchants= merchant::withTrashed()->get();
            $merchant=$merchants[0];
            // $req_merchant_id = $this->request->merchant?$this->request->merchant['id']:'';
            if (!empty($this->request->merchant)) {
                $this->where_merchant[]=['merchant_id','=',$this->request->merchant['id']];
            }

        }else{
            $merchant_user_id = Auth::User()->id;
            $this->merchant_id = $this->CmnController->getMerchantIdByUser($merchant_user_id);
            $this->where_merchant[]=['merchant_id','=',$this->merchant_id];
            $merchant= merchant::withTrashed()->find($this->merchant_id);
        }
            $search = $this->request->search;
            $per_page = $this->request->per_page;
            $status = $this->request->status;


            // $per_page = $per_page?$per_page:15;

            $data = parcel::with(['merchant','customer_address'])->whereHas('merchant',function($query) use($search){
                $query->orWhere('company_name', 'like', "%".$search."%");
            })->whereHas('customer_address',function($q) use($search){
                $q->join('districts','districts.id','=','customer_addresses.district_id');
                $q->join('customers','customers.id','=','customer_addresses.customer_id');
                $q->orWhere('districts.district_name', 'like', "%".$search."%");
                $q->orWhere('customers.customer_name', 'like', "%".$search."%");

            })->where($this->where_merchant);
            if ($search !=null) {
                $this->where_array=[
                    ['marchent_order_id',"like","%".$search."%"]
                ];
                // return $this->where_array;
            }
            if ($status!='All' && $status!=null) {
                $data =$data->where('status',$status);
            }
        //    $data = cache()->remember('parcelList',60*60*24,function(){

            $data =$data->where($this->where_array)->orderBy('id', 'desc');
            if (Auth::user()->hasRole(config('const.ADM_ROLE'))) {
                $data =$data->withTrashed();
            }
            $data =$data->paginate($per_page);

            return ParcelResource::collection($data)->additional([
                'merchant'=> $merchant,
                'merchants'=> $merchants,
            ]);
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
    public function store(ParcelRequest $request)
    {
        $area =$request->area;
        $charge_package =$request->charge_package;
        $charge_package_id =$request->charge_package_id;
        $collection_amount =$request->collection_amount;
        $customer =$request->customer;
        $customer_address =$request->customer_address;
        $contact_number =$request->contact_number;
        $customer_name =$request->customer_name;
        $deliveryOption =$request->deliveryOption;
        $delivery_charge =$request->delivery_charge;
        $delivery_option_charge =$request->delivery_option_charge;
        $delivery_option_rate =$request->delivery_option_rate;
        $district_id =$request->district_id;
        $marchent_order_id =$request->marchent_order_id;
        $merchant =$request->merchant;
        $new_customer_address =$request->new_customer_address;
        $pickup_address =$request->pickup_address;
        $product_description =$request->product_description;
        $remark =$request->remark;
        $selected_pickup_address =$request->selected_pickup_address;
        $thana_id =$request->thana_id;
        $weight_charge =$request->weight_charge;
        $weight_name =$request->weight_name;
        if (empty($customer)) {
            if ($customer_name!=null && $contact_number!=null) {
                $customer_id = customer::insertGetId([
                    'merchant_id'=>$merchant['merchant_id'],
                    'customer_name'=>$customer_name,
                    'contact_number'=>$contact_number,
                ]);
            }
            $customer_address_id = $this->customerAddressStore($request,$customer_id);
        }else{
            $customer_id = $customer['id'];
            if (empty($customer_address)) {
                $customer_address_id = $this->customerAddressStore($request,$customer_id);
            }else{
                $customer_address_id =$customer_address['id'];
            }
        }

        $parcel_array=array(
            'customer_address_id'=>$customer_address_id,
            'merchant_id'=>$merchant['merchant_id'],
            'charge_package_id'=>$charge_package_id,
            'delivery_option_id'=>$deliveryOption['option_id'],
            'marchent_order_id'=>$marchent_order_id,
            'selected_pickup_address'=>$selected_pickup_address,
            'pickup_address'=>$pickup_address,
            'product_description'=>$product_description,
            'remark'=>$remark,
        );
        $parcel_id=parcel::insertGetId($parcel_array);
        $charge_amount=$delivery_charge+$delivery_option_charge+$weight_charge;
        $total_collection=$charge_amount+$collection_amount;
        $parcel_account_array=array(
            'parcel_id'=>$parcel_id,
            'collection_amount'=>$collection_amount,
            'charge_amount'=>$charge_amount,
            'total_collection'=>$total_collection,
        );
        $parcel_account = parcel_account::insert($parcel_account_array);

        if ($parcel_account){
            return response()->json([
                'status' => '1',
                'class_name'=>'success',
                'icon' => 'check',
                'message' => 'Parcel has been created!'
            ]);
        }
    }
    private function customerAddressStore($request,$customer_id){
        $customer_address_id =null;
        if ($request->district_id!=null && $request->thana_id!=null && $request->new_customer_address!=null && !empty($request->area)) {
            $customer_address_id = customer_address::insertGetId([
                'customer_id'=>$customer_id,
                'district_id'=>$request->district_id,
                'thana_id'=>$request->thana_id,
                'area_id'=>$request->area['area_id'],
                'address'=>$request->new_customer_address,
            ]);
        }
        return $customer_address_id;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $merchant= merchant::withTrashed()->find($id);
        $data = parcel::withTrashed()->find($id);
        return (new ParcelResource($data))->additional([
            'merchant'=> new MerchantResource(merchant::withTrashed()->find($data->merchant_id)),
            'customers'=>CustomerResource::collection(customer::where('merchant_id',$data->merchant_id)->get()),
            // 'customer'=>new CustomerResource::collection(customer::where('merchant_id',$merchant_id)->get()),

        ]);

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
        $area =$request->area;
        $charge_package =$request->charge_package;
        $charge_package_id =$request->charge_package_id;
        $collection_amount =$request->collection_amount;
        $customer =$request->customer;
        $customer_address =$request->customer_address;
        $contact_number =$request->contact_number;
        $customer_name =$request->customer_name;
        $deliveryOption =$request->deliveryOption;
        $delivery_charge =$request->delivery_charge;
        $delivery_option_charge =$request->delivery_option_charge;
        $delivery_option_rate =$request->delivery_option_rate;
        $district_id =$request->district_id;
        $marchent_order_id =$request->marchent_order_id;
        $merchant =$request->merchant;
        $new_customer_address =$request->new_customer_address;
        $pickup_address =$request->pickup_address;
        $product_description =$request->product_description;
        $remark =$request->remark;
        $selected_pickup_address =$request->selected_pickup_address;
        $thana_id =$request->thana_id;
        $weight_charge =$request->weight_charge;
        $weight_name =$request->weight_name;

        // return $merchant['id'];
        if ($customer_name!=null && $contact_number!=null) {
            $customer_id = customer::insertGetId([
                'merchant_id'=>$merchant['id'],
                'customer_name'=>$customer_name,
                'contact_number'=>$contact_number,
            ]);
        }else{
            $customer_id = $customer['id'];
        }
        if (empty($customer_address)) {
            $customer_address_id = $this->customerAddressStore($request,$customer_id);
        }else{
            $customer_address_id =$customer_address['id'];
        }

        $parcel_array=[
            'customer_address_id'=>$customer_address_id,
            'merchant_id'=>$merchant['id'],
            'charge_package_id'=>$charge_package_id,
            'delivery_option_id'=>$deliveryOption['option_id'],
            'marchent_order_id'=>$marchent_order_id,
            'selected_pickup_address'=>$selected_pickup_address,
            'pickup_address'=>$pickup_address,
            'product_description'=>$product_description,
            'remark'=>$remark,
        ];
        parcel::withTrashed()->where('id',$id)->update($parcel_array);

        $charge_amount=$delivery_charge+$delivery_option_charge+$weight_charge;
        $total_collection=$charge_amount+$collection_amount;
        $parcel_account_array=array(
            // 'parcel_id'=>$id,
            'collection_amount'=>$collection_amount,
            'charge_amount'=>$charge_amount,
            'total_collection'=>$total_collection,
        );
        $parcel_account = parcel_account::where('parcel_id',$id)->update($parcel_account_array);

        if ($parcel_account){
            return response()->json([
                'status' => 1,
                'class_name'=>'success',
                'icon' => 'check',
                'message' => 'Parcel has been Updated!'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    public function destroy($parcel)
    {
        $parcel=json_decode($parcel,true);
        $parcel_id=$parcel['parcel_id'];
        $deleted_at=$parcel['deleted_at'];

        $parcel_var=parcel::where('id',$parcel_id);
        $ret_msg='';
        if ($deleted_at==null) {
            $parcel_var->delete();
            $ret_msg='Parcel deleted';
            $ret_title='Deleted!';
        }else{
            $parcel_var->withTrashed()->restore();
            $ret_msg='Parcel restored';
            $ret_title='Restored!';
        }
        return response()->json(['status'=>1,'message'=>$ret_msg,'class_name'=>'success','title'=>$ret_title]);
    }
    public function parcelStatusUpdate(Request $request){
        // return $request->all();
        $parcel_ids=$request->parcel_ids;
        $status=$request->status;
        foreach ($parcel_ids as $key => $value) {
            parcel::where('id',$value)->withTrashed()->update(['status'=>$status]);
        }
        return response()->json([
            'status' => 1,
            'class_name'=>'success',
            'icon' => 'check',
            'message' => 'Parcel(s) requested for pick'
        ]);
    }
    public function getParcelPdf(Request $request){
        $parcel_data_query=parcel::withTrashed();
        if ($request->has('id')) {
            $parcel_id=$request->id;
            $parcel_data=$parcel_data_query->where('id',$parcel_id)->get();
            // $data=new ParcelResource($parcel_data);
        }else{
            $parcel_data=$parcel_data_query->get();
        }
        $data=ParcelResource::collection($parcel_data);
        $pdf_data = $this->deliveryStatementPdf($data);
        return response()->json(['pdf_data'=>$pdf_data]);

    }
    public function deliveryStatementPdf($pdf_datas){
        $pdf_save_path=config('const.PARCEL_PDF_SAVE_PATH');
        $receipt=$this->fpdfRet();
        $receipt-> AddPage();
        $receipt->setSourceFile(storage_path(config('const.PARCEL_PDF_TEMPLATE_PATH')));
        $tplIdx = $receipt->importPage(1);
        $receipt->UseTemplate($tplIdx, null, null, null, null, true);
        $pdf_file_path= $this->pdfFileSave($receipt,"Parcel_PDF_".time().".pdf", $pdf_save_path);
        // array_push($pdf_file_paths, $pdf_file_path);
        Log::debug(__METHOD__.':end---');
        return $pdf_file_path;
    }
    public function fpdfRet()
    {
        Log::debug(__METHOD__.':start---');
        $receipt = new Fpdi();
        // Set PDF margins (top left and right)
        $receipt->SetMargins(0, 0, 0);

        // Disable header output
        $receipt->setPrintHeader(false);

        // Disable footer output
        $receipt->setPrintFooter(false);
        // $receipt->UseTemplate($tplIdx, null, null, null, null, true);
        $receipt->setFontSubsetting(true);
        // font declared
        $fontPathRegular = storage_path(config('const.MIGMIX_FONT_PATH'));
        $receipt->SetFont(\TCPDF_FONTS::addTTFfont($fontPathRegular), '', 8, '', true);

        Log::debug(__METHOD__.':end---');

        return $receipt;
    }
    public function pdfFileSave($receipt, $pdf_file_name=null,$pdf_save_path)
    {
        Log::debug(__METHOD__.':start---');
        // $pdf_file_name=date('YmdHis').'_'.$file_number.'_receipt.pdf';
        // $pdf_file_name=$new_file_name;

        $this->folder_create($pdf_save_path);
        $response = new Response(
            $receipt->Output(storage_path($pdf_save_path.$pdf_file_name), 'F'),
            200,
            array('content-type' => 'application / pdf')
        );
        $pdf_file_url = Config::get('app.url').'storage/'.$pdf_save_path.$pdf_file_name;
        $pdf_file_path = storage_path($pdf_save_path.$pdf_file_name);
        $file_info=array(
            'file_url'=>$pdf_file_url,
            'file_name'=>$pdf_file_name,
            'file_path'=>$pdf_file_path
        );
        Log::debug(__METHOD__.':end---');
        return $file_info;
    }
    public function folder_create($folder_name)
    {
        if (!file_exists(storage_path() . '/' . $folder_name)) {
            mkdir(storage_path() . '/' . $folder_name, 0777, true);
        }
    }

}
