<?php

namespace App\Http\Controllers\API\BACKEND\CMN;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\BACKEND\CMN\CustomerResource;
use App\Models\APPLICATION\charge_list;
use App\Models\APPLICATION\charge_package;
use App\Models\APPLICATION\delivery_option;
use App\Models\APPLICATION\weight_list;
use App\Models\CMN\customer;
use App\Models\CMN\customer_address;
use App\Models\COUNTRY\area;
use App\Models\COUNTRY\district;
use App\Models\COUNTRY\thana;
use App\Models\HUB\hub;
use App\Models\MERCHANT\merchant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
require_once base_path('vendor/tecnickcom/tcpdf/tcpdf.php');
use setasign\Fpdi\Tcpdf\Fpdi;
use tecnickcom\tcpdf\TCPDF_FONTS;

class CmnController extends Controller
{
    public function districts(Request $request,$id=null){
        $districts_var=district::select('id as district_id','district_name');
        if ($id==null) {
            $districts=$districts_var->get();
        }else{
            $districts=$districts_var->where('id',$id)->first();
        }
        return response()->json(['districts'=>$districts]);
    }
    public function hubs(Request $request,$id=null){
        $hubs=hub::select('id as hub_id','hub_name');
        if ($id==null) {
            $hubs=$hubs->get();
        }else{
            $hubs=$hubs->where('id',$id)->first();
        }
        return response()->json(['hubs'=>$hubs]);
    }
    // $id is thana id
    // $district_id is district id
    public function thanas(Request $request, $id=null,$district_id=null){
        $id= $id==null?$request->id: $id;
        $district_id= $district_id==null?$request->district_id: $district_id;

        $thanas_var=thana::select('id as thana_id','district_id','thana_name','thana_distance');
        if ($id==null&&$district_id==null) {
            $thanas=$thanas_var->get();
        }elseif($id!=null&&$district_id==null){
            $thanas=$thanas_var->where('id',$id)->first();
        }elseif($id!=null&&$district_id!=null){
            $thanas=$thanas_var->where('id',$id)->where('district_id',$district_id)->first();
        }elseif($id==null&&$district_id!=null){
            $thanas=$thanas_var->where('district_id',$district_id)->get();
        }
        return response()->json(['thanas'=>$thanas]);
    }
    // $id is area id
    // $thana_id is thana_id id
    public function areas(Request $request,$id=null,$thana_id=null){
        $id= $id==null?$request->id: $id;
        $thana_id= $thana_id==null?$request->thana_id: $thana_id;

        $areas_var=area::select('id as area_id','thana_id','area_name','area_distance');
        if ($id==null&&$thana_id==null) {
            $areas=$areas_var->get();
        }elseif($id!=null&&$thana_id==null){
            $areas=$areas_var->where('id',$id)->first();
        }elseif($id!=null&&$thana_id!=null){
            $areas=$areas_var->where('id',$id)->where('thana_id',$thana_id)->first();
        }elseif($id==null&&$thana_id!=null){
            $areas=$areas_var->where('thana_id',$thana_id)->get();
        }
        return response()->json(['areas'=>$areas]);
    }
    public function getMerchant(Request $request){
        // $status=$request->status;
        $user_id=Auth::User()->id;
        $merchant_id=$this->getMerchantIdByUser($user_id);
        $merchants=array();
        $merchant=array();
        $customers=array();
        $merchants_query=merchant::select(
        'merchants.id as merchant_id','merchants.company_name','merchants.full_address',
        'merchants.business_address', 'au.name as merchant_name', 'merchants.phone')
        ->join('users as au','au.id','=','merchants.user_id')
        ->join('users_details as aud','aud.user_id','=','au.id');
        if (Auth::user()->hasRole(config('const.ADM_ROLE'))) {
            $merchants= $merchants_query->get();
            $merchant=$merchants[0];
        }else{
            $merchant= $merchants_query->where('merchants.id',$merchant_id)->first();
            $customers=$this->getCustomerByMerchant($merchant_id);
            // $customers=CustomerResource::collection($customers_data);
        }
        $chargeLists=$this->getAllChargeList();
        $deliveryOptions=$this->deliveryOptions();
        // $weight_lists = weight_list::get();
        // $customer_lists = customer::select('id as customer_id','customer_name','contact_number')->get();
        return response()->json(['merchants'=>$merchants,'merchant'=>$merchant,'chargeLists'=>$chargeLists,'deliveryOptions'=>$deliveryOptions,'customers'=>$customers]);
    }
    public function getCustomerByMerchant($merchant_id){
        $customers_data=customer::where('merchant_id',$merchant_id)->get();
        return $customers=CustomerResource::collection($customers_data);
    }
    public function get_customer_address_by_id($id){
        $allCustomers=customer_address::select('id as customer_address_id','address','thana_id','area_id','district_id')->where('customer_id',$id)->get();
        return response()->json(['allCustomers'=>$allCustomers]);
    }
    public function getMerchantIdByUser($user_id){
        $merchant_info=merchant::select('id as merchant_id')->where('user_id',$user_id)->first();
        $merchant_id=null;
        if (!empty($merchant_info)) {
            $merchant_id=$merchant_info->merchant_id;
        }
        return $merchant_id;
    }
    public function getAllChargeList($id=null){
        $chargeLists=charge_list::select('charge_lists.id as charge_list_id',
        'charge_lists.district_id','charge_lists.charge_rate','d.district_name')
        ->join('districts as d','d.id','=','charge_lists.district_id');
        if ($id==null) {
            $chargeLists=$chargeLists->get();
        }else{
            $chargeLists=$chargeLists->where('charge_lists.district_id',$id)->first();
        }

        return $chargeLists;
    }
    public function deliveryOptions(){
        $delivery_options=delivery_option::select('id as option_id','option_name','option_rate')->get();
        return $delivery_options;
    }
    public function weightList(Request $request)
    {
        $charge_list_id=$request->charge_list_id;
        $weight_lists = charge_package::select('charge_packages.id as charge_package_id',
        'charge_packages.charge_list_id','charge_packages.weight_list_id','charge_packages.charge',
        'wl.weight_name')
        ->join('weight_lists as wl','wl.id','=','charge_packages.weight_list_id')
        ->where('charge_packages.charge_list_id',$charge_list_id)
        ->get();
        return response()->json(['weight_lists'=>$weight_lists]);
    }
    public function allCustomers($id=null){
        return customer::select('customers.id as customer_id','customers.merchant_id',
        'customers.customer_name','customers.contact_number','ca.id as customer_address_id',
        'ca.district_id','ca.thana_id','ca.area_id','ca.address')
        ->join('customer_addresses as ca','ca.customer_id','=','customers.id')
        ->get();
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
