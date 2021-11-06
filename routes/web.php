<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('language/{locale}', function ($locale) {
    // return $locale;
    Session::put('locale',$locale);

    return redirect()->back();
});

Route::get('/admin/{any?}', 'API\BACKEND\ADMIN\HomeController@index')->where('any', '.*');
Route::get('/{any?}', 'API\FRONTEND\DFLT\HomeController@index')->where('any', '.*');

