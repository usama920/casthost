<?php

use App\Http\Controllers\Super\SuperApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group(['middleware' => 'api_auth'], function () {
    Route::post('/v1/create/admin', [ SuperApiController::class, 'CreateAdmin']);
    Route::post('/v1/suspend/admin', [SuperApiController::class, 'SuspendAdmin']);
    Route::post('/v1/unsuspend/admin', [SuperApiController::class, 'UnsuspendAdmin']);
    Route::post('/v1/delete/admin', [SuperApiController::class, 'DeleteAdmin']);
});
