<?php

use Illuminate\Http\Request;
Use App\Customer;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/shops', 'ShopController@index');
Route::get('shops/{shop}', 'ShopController@show');
Route::post('shops', 'ShopController@storeApi');
Route::post('shops/update/{id}', 'ShopController@update');
Route::delete('shops/{shop}', 'ShopController@delete');
Route::post('shops/photo/upload', 'ShopController@uploadShopPhoto');

Route::get('/categories', 'CategoryController@index');

Route::get('/categories/shops', 'CategoryController@ShopWithCategory');

Route::get('customers', 'CustomerController@index');
Route::get('customers/{customer}', 'CustomerController@show');
Route::post('customers', 'CustomerController@store');
Route::post('customers/already/exist', 'CustomerController@checkCustomerAlreadyExit');
Route::post('customers/update/', 'CustomerController@update');
Route::delete('customers/{customer}', 'CustomerController@delete');
Route::post('customers/photo/upload', 'CustomerController@uploadCustomerPhoto');
Route::post('customers/reset/password', 'CustomerController@resetPassword');

Route::post('customers/renew/luckydraw', 'CustomerController@renewLuckydraw');
Route::post('customers/renew/luckydraw/confirm', 'CustomerHistoryController@confirmLuckydraw');

Route::post('customers/login', 'CustomerController@login');

Route::get('noti', 'NotiController@getLatestNoti');

Route::get('pincodes', 'PinCodeController@index');
Route::get('pincodes/{pin}', 'PinCodeController@show');
Route::post('pincodes', 'PinCodeController@store');
Route::put('pincodes/{pin}', 'PinCodeController@update');
Route::delete('pincodes/{pin}', 'PinCodeController@delete');

Route::post('pincodes/verify', 'PinCodeController@verifiedPinCode');

Route::get('sms/pins', 'SmsPinController@index');
Route::get('sms/pins/{sms}', 'SmsPinController@show');
Route::post('sms/pins', 'SmsPinController@store');
Route::put('sms/pins/{sms}', 'SmsPinController@update');
Route::delete('sms/pins/{sms}', 'SmsPinController@delete');

Route::post('feedbacks/store', 'FeedbackController@store');

Route::post('sms/pins/verify', 'SmsPinController@verifiedSmsCode');

Route::get('emergency_contact/data','EmergencyContactController@ApiGetData');
