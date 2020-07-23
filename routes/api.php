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

Route::post('login', 'API\LoginController@login');
Route::group(['middleware' => 'auth:api'], function(){
    Route::post('get-promotions', 'API\PromotionsController@getPromotionsList');
    Route::post('get-promotion-by-id', 'API\PromotionsController@getPromotionById');
});
Route::fallback(function(){
    return response()->json([
        'success' => false,
        'response' => [
            'data' => [],
            'error' => [
                'field' => 'api_router',
                'code' => 'api_router_http_method_not_allowed_or_api_method_not_defined',
                'message' => 'API Router failure: HTTP Method not allow or API route not defined'
            ]
        ]
    ], 404);
});
