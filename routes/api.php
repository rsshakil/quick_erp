<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'API\BACKEND\AUTH\AuthController@login');
    Route::post('logout', 'API\BACKEND\AUTH\AuthController@logout');
    Route::post('refresh', 'API\BACKEND\AUTH\AuthController@refresh');
    Route::post('me', 'API\BACKEND\AUTH\AuthController@me');

});
/* not authentic route*/
Route::group([

    'middleware' => 'api'

], function ($router) {

    Route::apiResources(
        [
            'merchant'=>'API\BACKEND\MERCHANT\MerchantsController',
        ]
    );
    Route::post('/get_districts', 'API\BACKEND\CMN\CmnController@districts');
    Route::post('/get_thanas', 'API\BACKEND\CMN\CmnController@thanas');
    Route::post('/get_areas', 'API\BACKEND\CMN\CmnController@areas');
});
Route::group([
    'middleware' => 'jwt.auth',
], function ($router) {
    Route::apiResources(
        [
            'role' => 'API\BACKEND\ADMIN\RoleController',
            'permission' => 'API\BACKEND\ADMIN\PermissionController',
            'users' => 'API\BACKEND\ADMIN\UsersController',
        ]
    );

    Route::get('/all_users_roles', 'API\BACKEND\ADMIN\AssignRoleModel@allUsersAndRoles');
    Route::get('/get_roles/{id}', 'API\BACKEND\ADMIN\AssignRoleModel@getRoleById');
    Route::post('/assign_role_to_user', 'API\BACKEND\ADMIN\AssignRoleModel@assignModelRole');

    Route::get('/all_users_permissions', 'API\BACKEND\ADMIN\AssignPermissionModel@allUsersAndPermissions');
    Route::get('/get_permission_model/{id}', 'API\BACKEND\ADMIN\AssignPermissionModel@getPermissionModel');
    Route::post('/assign_permission_to_user', 'API\BACKEND\ADMIN\AssignPermissionModel@assignPermissionToModel');

    Route::post('/get_permission_for_roles', 'API\BACKEND\ADMIN\AssignPermissionModel@getPermissionsByRole');
    Route::post('/permissions_by_users', 'API\BACKEND\ADMIN\AssignPermissionModel@getPermissionsByUser');
    Route::post('/change_password', 'API\BACKEND\ADMIN\UsersController@changePassword');

    Route::get('/user_details/{user_id}', 'API\BACKEND\ADMIN\UsersController@userDetails');
    Route::post('/users_update', 'API\BACKEND\ADMIN\UsersController@update');

    Route::get('/home_lang_data', 'API\BACKEND\ADMIN\LanguageController@homeLangData');
    // Merchant
    //Route::get('/merchants', 'API\BACKEND\MERCHANT\MerchantController@index');
    //Route::get('/merchants/{id?}', 'API\BACKEND\MERCHANT\MerchantController@show');
    Route::post('/get_single_merchant', 'API\BACKEND\MERCHANT\MerchantController@getSingleMerchant');
    Route::post('/add_merchant', 'API\BACKEND\MERCHANT\MerchantController@addMerchant');
    Route::post('/update_merchant', 'API\BACKEND\MERCHANT\MerchantController@updateMerchant');
    Route::post('/change_merchant_status', 'API\BACKEND\MERCHANT\MerchantController@changeMerchantStatus');
    Route::post('/merchant_delete_or_retrive', 'API\BACKEND\MERCHANT\MerchantController@merchantDeleteRetrive');
   
    Route::post('/get_merchant', 'API\BACKEND\CMN\CmnController@getMerchant');
    Route::post('/get_weight_list', 'API\BACKEND\CMN\CmnController@weightList');
    Route::get('/get_district_charge/{id?}', 'API\BACKEND\CMN\CmnController@getAllChargeList');
    Route::get('/get_customer_address_by_id/{id?}', 'API\BACKEND\CMN\CmnController@get_customer_address_by_id');
    Route::get('/get_customer_by_merchant/{id?}', 'API\BACKEND\CMN\CmnController@getCustomerByMerchant');
    Route::post('/parcels', 'API\BACKEND\PARCEL\ParcelController@index');

    Route::post('/parcel_status_update', 'API\BACKEND\PARCEL\ParcelController@parcelStatusUpdate');
    Route::post('/get_parcel_pdf', 'API\BACKEND\PARCEL\ParcelController@getParcelPdf');

    // Route::post('/get_all_charges', 'API\BACKEND\CMN\CmnController@areas');
    Route::post('/get_hubs', 'API\BACKEND\CMN\CmnController@hubs');

    Route::apiResources(
        [
            'home' => 'API\BACKEND\CMN\HomeController',
            'charges' => 'API\BACKEND\APPLICATION\ChargeController',
            'weigths' => 'API\BACKEND\APPLICATION\WeightController',
            'charge_package' => 'API\BACKEND\APPLICATION\ChargePackageController',
            'delivery_options' => 'API\BACKEND\APPLICATION\DeliveryOptionController',
            'merchants'=>'API\BACKEND\MERCHANT\MerchantsController',
            'parcel'=>'API\BACKEND\PARCEL\ParcelController',
            'hubs'=>'API\BACKEND\HUB\HubController',
            'hub-users'=>'API\BACKEND\HUB_USER\HubUserController',

        ]
    );
});
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
// Authentication Route
// Route::group(['middleware'=>'MyMiddleWire'],function(){

		// Route::post('/permission_check', 'API\PermissionController@check');

	// });
