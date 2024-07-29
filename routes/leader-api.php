<?php

use App\Http\Controllers\Leader\CountryController;
use App\Http\Controllers\Leader\CustomerController;
use App\Http\Controllers\Leader\DashboardController;
use App\Http\Controllers\Leader\ExportController;
use App\Http\Controllers\Leader\InsuranceController;
use App\Http\Controllers\Leader\NewsController;
use App\Http\Controllers\Leader\PackageController;
use App\Http\Controllers\Leader\ProductController;
use App\Http\Controllers\Leader\ProjectController;
use App\Http\Controllers\Leader\RecordController;
use App\Http\Controllers\Leader\SettingController;
use App\Http\Controllers\Leader\TeamController;
use App\Http\Controllers\Leader\UserController;
use App\Http\Controllers\Leader\WalletController;
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

// Protected routes->middleware(['jwt.auth', 'check-creator']);
//Route::middleware('jwt.auth')->group(function () {
Route::group(['middleware' => ['jwt.auth', 'check-leader']], function () {

    Route::group(['prefix' => 'dashboard'], function () {
        Route::get('home', [DashboardController::class, 'home']);
        Route::get('header', [DashboardController::class, 'header']);
    });

    Route::group(['prefix' => 'user'], function () {
        Route::post('/registerMember', [UserController::class, 'registerMember']);
        Route::post('/delete_Leader', [UserController::class, 'delete_Leader']);
        Route::get('userlist', [UserController::class, 'user_list']);
        Route::get('user_list', [UserController::class, 'user_list']);
        Route::get('/Leader_list', [UserController::class, 'Leader_list']);
        Route::post('/update_Leader', [UserController::class, 'update_Leader']);
        Route::post('/create_Leader', [UserController::class, 'create_Leader']);
        Route::get('get_user_info', [UserController::class, 'get_user_info']);
        Route::get('/userPackage', 'UserController@userPackage');
        Route::post('updateUser', [UserController::class, 'updateUser']);
        Route::post('userSetting', [UserController::class, 'userSetting']);

        Route::post('updatePwd', [UserController::class, 'updatePwd']);

        Route::get('kycList', [UserController::class, 'kycList']);
        Route::post('kycControl', [UserController::class, 'kycControl']);
        Route::get('kycHis', [UserController::class, 'kycHis']);
    });
    Route::group(['prefix' => 'project'], function () {
        Route::post('approveQuit', [ProjectController::class, 'approveQuit']);
        Route::post('cancelQuit', [ProjectController::class, 'cancelQuit']);
        Route::get('quitRecord', [ProjectController::class, 'quitRecord']);
        Route::get('convertInvestRecord', [ProjectController::class, 'convertInvestRecord']);
        Route::get('stakingList', [ProjectController::class, 'stakingList']);
        Route::get('packageTypeList', [ProjectController::class, 'packageTypeList']);
        Route::post('packageTypeControl', [ProjectController::class, 'packageTypeControl']);
    });
    Route::group(['prefix' => 'package'], function () {
        Route::get('getPackage', [PackageController::class, 'getPackage']);
        Route::post('addPackage', [PackageController::class, 'addPackage']);
        Route::get('quitList', [PackageController::class, 'quitList']);
        Route::post('quitOperate', [PackageController::class, 'quitOperate']);
        Route::get('userGroup', [PackageController::class, 'userGroup']);
        Route::post('userGroupControl', [PackageController::class, 'userGroupControl']);
        Route::get('shenHeList', [PackageController::class, 'shenHeList']);
        Route::get('investRecList', [PackageController::class, 'investRecList']);
        Route::get('contractInvestRecList', [PackageController::class, 'contractInvestRecList']);
        Route::get('groupingRecordList', [PackageController::class, 'groupingRecordList']);
    });

    Route::group(['prefix' => 'export'], function () {
        Route::get('/exportBonus', [ExportController::class, 'exportBonus']);
        Route::get('/exportWithdrawHis', [ExportController::class, 'exportWithdrawHis']);
        Route::get('/exportWithdrawList', [ExportController::class, 'exportWithdrawList']);
        Route::get('/exportReloadRecord', [ExportController::class, 'exportReloadRecord']);
        Route::get('/exportTransactionRecord', [ExportController::class, 'exportTransactionRecord']);
        Route::get('/exportUser', [ExportController::class, 'exportUser']);
        Route::get('/exportWallet', [ExportController::class, 'exportWallet']);
        Route::get('/exportWalletChangeRec', [ExportController::class, 'exportWalletChangeRec']);
        Route::get('/exportPackageRecord', [ExportController::class, 'exportPackageRecord']);
        Route::get('/exportQuitRecord', [ExportController::class, 'exportQuitRecord']);
        Route::get('/exportInvestRecord', [ExportController::class, 'exportInvestRecord']);
        Route::get('/exportUplineRecord', [ExportController::class, 'exportUplineRecord']);
        Route::get('/exportDownlineRecord', [ExportController::class, 'exportDownlineRecord']);
        Route::get('/exportUserSalesRecord', [ExportController::class, 'exportUserSalesRecord']);
    });

    Route::group(['prefix' => 'wallet'], function () {
        Route::get('/walletChangeRec', [WalletController::class, 'walletChangeRec']);
        Route::post('/changeWallet', [WalletController::class, 'changeWallet']);
        Route::get('/withdrawList', [WalletController::class, 'withdrawList']);
        Route::get('/withdrawHis', [WalletController::class, 'withdrawHis']);
        Route::post('/withdrawControl', [WalletController::class, 'withdrawControl']);
        Route::post('/batchWithdrawControl', [WalletController::class, 'batchWithdrawControl']);
        //////////////new changed ////////////////////

        Route::get('/depositList', [WalletController::class, 'depositList']);
        Route::post('/depositControl', [WalletController::class, 'depositControl']);
        Route::get('/depositCoinList', [WalletController::class, 'depositCoinList']);
        Route::post('/depositCoinControl', [WalletController::class, 'depositCoinControl']);
//new api
        Route::get('/depositRequestList', [WalletController::class, 'depositRequestList']);
        Route::post('/depositRequestControl', [WalletController::class, 'depositRequestControl']);

        Route::get('/withdrawCashList', [WalletController::class, 'withdrawCashList']);
        Route::post('/editWithdrawCash', [WalletController::class, 'editWithdrawCash']);
        Route::get('/withdrawCashHis', [WalletController::class, 'withdrawCashHis']);
        Route::post('/withdrawCashControl', [WalletController::class, 'withdrawCashControl']);

        Route::post('/editWithdrawCoin', [WalletController::class, 'editWithdrawCoin']);
        Route::get('/reloadRecord', [WalletController::class, 'reloadRecord']);
        //

    });
    Route::group(['prefix' => 'insurance'], function () {

        //follower

        Route::get('followerUserList', [InsuranceController::class, 'followerUserList']);
        Route::get('followList', [InsuranceController::class, 'followList']);

        Route::post('/followControl', [InsuranceController::class, 'followControl']);

        Route::post('/followerClaim', [InsuranceController::class, 'followerClaim']);
        //end follower
        Route::get('claimRecord', [InsuranceController::class, 'claimRecord']);

        Route::post('/claimControl', [InsuranceController::class, 'claimControl']);
        Route::get('claimHis', [InsuranceController::class, 'claimHis']);
        Route::get('/insuranceBetRecord', [InsuranceController::class, 'insuranceBetRecord']);
        Route::get('surenderRecord', [InsuranceController::class, 'surenderRecord']);
        Route::get('surenderHis', [InsuranceController::class, 'surenderHis']);
        Route::post('/surenderControl', [InsuranceController::class, 'surenderControl']);
        Route::get('/revertRecord', [InsuranceController::class, 'revertRecord']);
        Route::post('/revertControl', [InsuranceController::class, 'revertControl']);
    });

    Route::group(['prefix' => 'record'], function () {
        Route::get('otpRecord', [RecordController::class, 'otpRecord']);
        Route::get('walletRecord', [RecordController::class, 'walletRecord']);
        Route::get('userWalletRecord', [RecordController::class, 'userWalletRecord']);
        Route::get('bonusRecord', [RecordController::class, 'bonusRecord']);
        Route::get('userPackageRecord', [RecordController::class, 'userPackageRecord']);
        Route::get('teamReport', [RecordController::class, 'teamReport']);
        Route::get('exportTeamReport', [RecordController::class, 'exportTeamReport']);
    });
    Route::group(['prefix' => 'team'], function () {
        Route::get('/getUplinelineSale', [TeamController::class, 'getUplinelineSale']);
        Route::get('/getDownlineSale', [TeamController::class, 'getDownlineSale']);
        Route::get('/getUserSales', [TeamController::class, 'getUserSales']);
        Route::get('/sponsorTree', [TeamController::class, 'sponsorTree']);
        Route::get('/jstree_ajax_data', [TeamController::class, 'jstree_ajax_data']);
    });

    Route::group(['prefix' => 'news'], function () {
        Route::get('/newsList', [NewsController::class, 'newsList']);
        Route::post('/newsControl', [NewsController::class, 'newsControl']);
        Route::get('/newsInfo', [NewsController::class, 'newsInfo']);
    });
    Route::group(['prefix' => 'customer'], function () {
        Route::get('/ticketList', [CustomerController::class, 'ticketList']);
        Route::post('/ticketControl', [CustomerController::class, 'ticketControl']);
        Route::get('/ticketInfo', [CustomerController::class, 'ticketInfo']);
        Route::post('/markRead', [CustomerController::class, 'markRead']);
        Route::get('/countRead', [CustomerController::class, 'countRead']);
    });
    Route::group(['prefix' => 'setting'], function () {
        Route::get('/systemConfig', [SettingController::class, 'systemConfig']);
        Route::post('/saveConfig', [SettingController::class, 'saveConfig']);

        Route::get('/packageConfig', 'SettingController@packageConfig');
        Route::post('/savePackage', 'SettingController@savePackage');
    });

    //boost system
    Route::group(['prefix' => 'product'], function () {
        Route::get('/productList', [ProductController::class, 'productList']);
        Route::get('/getProductByPrice', [ProductController::class, 'getProductByPrice']);
        Route::post('/productControl', [ProductController::class, 'productControl']);
        Route::get('/productInfo', [ProductController::class, 'productInfo']);
    });
    Route::group(['prefix' => 'chat'], function () {
        Route::get('chatlist', [ChatController::class, 'chatlist']);
        Route::get('getChat', [ChatController::class, 'getChat']);
        Route::get('getChatNotification', [ChatController::class, 'getChatNotification']);
        Route::post('sentChat', [ChatController::class, 'sentChat']);
    });
    Route::group(['prefix' => 'country'], function () {
        Route::get('/coutryList', [CountryController::class, 'coutryList']);
        Route::post('/countryControl', [CountryController::class, 'countryControl']);
        Route::get('/countryInfo', [CountryController::class, 'countryInfo']);

        Route::get('/bankList', [CountryController::class, 'bankList']);
        Route::post('/bankControl', [CountryController::class, 'bankControl']);
        Route::get('/bankInfo', [CountryController::class, 'bankInfo']);
    });
});
