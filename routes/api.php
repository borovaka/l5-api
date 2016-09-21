<?php

use Illuminate\Http\Request;

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

Route::get('user',function () {
    return \App\ApiService\ApiResponse::send(Auth::guard('api')->user());
})->middleware('auth:api');
Route::put('user',function (Request $request) {
    $user = Auth::guard('api')->user();
    $user->update($request->all());
    return \App\ApiService\ApiResponse::send($user);
})->middleware('auth:api');