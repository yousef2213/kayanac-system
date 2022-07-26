<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\Apis\CompanyController;
// namespace App\Http\Controllers\Apis;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('Apis')->group(function() {

    Route::get('company', "CompanyController@company");
    Route::get('branchs', "HomeController@getBranchs");
    Route::get('customers', "HomeController@getCustomers");
    Route::post('login', "LoginController@login");
    Route::get('home', "HomeController@index");
    Route::get('items', "HomeController@items");
    Route::get('pos', "HomeController@POS");
    Route::get('/pos/getItemsGroups/{id}', "HomeController@getItemsGroups");
    Route::post('/pos/save', "HomeController@savePos");


    // كارت الصنف
    Route::post('items/filter', "HomeController@itemFilter");
    // تقارير المبيعات
    Route::post('/filter-items-sale', 'HomeController@FilterItems');
    // تقارير المشتريات
    Route::post('/filter-items-purchases', 'HomeController@FilterItemsPurchases');
    // داتا ارصدة الاصناف
    Route::get('/itemsBalance', 'HomeController@itemsBalance');
    Route::post('/itemsBalance/filter', 'HomeController@itemsBalanceFilter');
});




Route::post('/create_refrence', "ApiController@CreateRef");
Route::delete('/delete_refrence/{name}', "ApiController@DeleteRef");
