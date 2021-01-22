<?php

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

use App\Http\Controllers\CustomerHistoryController;

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
Route::get('/admins/forgot/password', 'AdminController@forgotPasswordUi');
Route::post('/admins/reset/password', 'AdminController@resetPasswordUi');

Route::middleware('auth')->group(function () {
    Route::get('/home', 'ShopController@uiGetALlShops')->name('home');

    Route::get('/shops', 'ShopController@uiTableGetALlShops');
    Route::get('/shops/show/{id}', 'ShopController@show');
    Route::get('/shops/create', 'ShopController@create');
    Route::post('/shops/store', 'ShopController@store');
    Route::get('/shops/search', 'ShopController@search');
    Route::delete('/shops/delete/{id}', 'ShopController@deleteShop');
    Route::get('/shops/edit/{id}', 'ShopController@editShop');
    Route::post('/shops/update/{id}', 'ShopController@updateShop');

    //shop download
    Route::get('shops/export', 'ShopController@export');

    Route::get('/categories', 'CategoryController@uiGetALlCategories');
    Route::get('/categories/create', 'CategoryController@create');
    Route::post('/categories/store', 'CategoryController@store');
    Route::delete('/categories/delete/{id}', 'CategoryController@deleteCategory');
    Route::post('/categories/edit/{id}', 'CategoryController@editCategory');
    Route::post('/categories/update/{id}', 'CategoryController@updateCategory');

    //city category routes...
    Route::get('/city-categories','CategoryController@cityWebIndex');
    Route::get('/city-categories/create','CategoryController@cityWebCreate');
    Route::post('/city-categories/store','CategoryController@cityWebStore');
    Route::get('/city-categories/edit/{city_id}','CategoryController@cityWebEdit');
    Route::put('/city-categories/update/{city_id}','CategoryController@cityWebUpdate');
    Route::delete('/city-categories/delete/{city_id}','CategoryController@cityWebDelete');

    //EmergencyContact routes...
    Route::get('/emergency_contact','EmergencyContactController@ECWebIndex');
    Route::get('/emergency_contact/create','EmergencyContactController@ECWebCreate');
    Route::post('/emergency_contact/store','EmergencyContactController@ECWebStore');
    Route::get('/emergency_contact/edit/{ec_id}','EmergencyContactController@ECWebEdit');
    Route::put('/emergency_contact/update/{ec_id}','EmergencyContactController@ECWebUpdate');
    Route::get('/emergency_contact/detail/{ec_id}','EmergencyContactController@ECWebDetail');
    Route::delete('/emergency_contact/delete/{ec_id}','EmergencyContactController@ECWebDelete');

    Route::get('pincodes', 'PinCodeController@indexUi');
    Route::get('/pincodes/create', 'PinCodeController@create');
    Route::get('pincodes/export', 'PinCodeController@export');
    Route::get('pincodes/{pin}', 'PinCodeController@show');
    Route::any('/pincodes-filter', 'PinCodeController@filter');
    Route::post('pincodes', 'PinCodeController@store');
    Route::post('pincodes/generate', 'PinCodeController@generate');
    Route::put('pincodes/{pin}', 'PinCodeController@updateUi');
    Route::delete('pincodes/{pin}', 'PinCodeController@deleteUi');


    Route::get('sendbasicemail', 'CustomerController@basic_email');
    Route::get('sendhtmlemail', 'CustomerController@html_email');
    Route::get('sendattachmentemail', 'CustomerController@attachment_email');

    Route::get('customers', 'CustomerController@indexUi');
    Route::get('customers/create', 'CustomerController@create');
    Route::get('customers/noti', 'CustomerController@notiform');
    Route::get('customers/export', 'CustomerController@export');
    Route::post('customers/noti/send', 'CustomerController@pushnoti');
    Route::post('customers/store', 'CustomerController@storeUi');
    Route::get('customers/edit/{id}', 'CustomerController@edit');
    Route::get('customers/{id}/history', 'CustomerHistoryController@viewCustomerHistory');
    Route::get('customers/{pin}', 'CustomerController@showUi');
    Route::put('customers/{pin}', 'CustomerController@updateUi');
    Route::delete('customers/delete/{id}', 'CustomerController@deleteUi');
    Route::post('/customers/update/{id}', 'CustomerController@updateCustomer');


    Route::get('customer/history', 'CustomerHistoryController@index');
    Route::any('/customer/history/search', 'CustomerHistoryController@search');
    Route::post('/customer/claim', 'CustomerHistoryController@claimCustomer');

    Route::get('/typeahead/customer/name', 'CustomerController@cusNameAutocomplete')->name('typeahead.customer.name');

    Route::get('feedbacks', 'FeedbackController@index');
    Route::get('/feedbacks/show/{feedback}', 'FeedbackController@show');
    Route::delete('/feedbacks/delete/{id}', 'FeedbackController@destroy');


    Route::get('admins', 'AdminController@indexUi');
    Route::get('admins/create', 'AdminController@create');
    Route::post('admins/store', 'AdminController@storeUi');
    Route::post('admins/edit/{pin}', 'AdminController@editUi');
    Route::post('admins/update/{pin}', 'AdminController@update');
    Route::delete('admins/delete/{id}', 'AdminController@deleteUi');

    Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
});
