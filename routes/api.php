<?php

use App\Http\Controllers\Api\ContractController;
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

Route::group(['middleware' => 'guest:api'], function () {

    Route::get('/contract-data', [ContractController::class, 'getContractData']);
    Route::get('/send-transaction', [ContractController::class, 'sendTransaction']);
    Route::get('/checkTransaction/{txHash}', [ContractController::class, 'checkTransactionStatus']);
    Route::get('getUserAddress', [ContractController::class, 'getUserAddress']);
    Route::get('getMarketPrice', [ContractController::class, 'getMarketPrice']);
    Route::get('systemPledge', [ContractController::class, 'systemPledge']);
});
// Protected routes
Route::middleware(['jwt.auth', 'preventDuplicateSubmissions'])->group(function () {

    Route::group(['prefix' => 'member'], function () {
        //special

        Route::get('getUserAddress', [ContractController::class, 'getUserAddress']);
    });

});
