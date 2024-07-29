<?php

use App\Http\Controllers\Api\APIController;
use App\Http\Controllers\Api\CronjobController;
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
    Route::group(['prefix' => 'news'], function () {
        Route::get('banner-list', [NewsController::class, 'bannerList']);
        Route::get('news-list', [NewsController::class, 'newsList']);
    });
    Route::group(['prefix' => 'cronjob'], function () {

        Route::get('checkBalance', [Web3Controller::class, 'checkBalance']);
        Route::get('generateAddress', [Web3Controller::class, 'generateAddress']);
        Route::post('heavytest', [RobortController::class, 'heavytest']);
        Route::get('test', [APIController::class, 'test']);
        Route::get('CheckRank', [CronjobController::class, 'CheckRank']);
        Route::get('checkBTCprice', [CronjobController::class, 'checkBTCprice']);
        Route::get('introduce', [CronjobController::class, 'introduce']);
        Route::get('jiedian', [CronjobController::class, 'jiedian']);
        // Route::get('RunMatchingBonus', [CronjobController::class, 'RunMatchingBonus']);
        Route::get('RunRoiBonus', [CronjobController::class, 'RunRoiBonus']);
        Route::get('RunRankBonus', [CronjobController::class, 'RunRankBonus']);
        Route::get('releaseBonus', [CronjobController::class, 'releaseBonus']);
        Route::get('SetSite', [CronjobController::class, 'SetSite']);
        Route::get('dairlyJob', [CronjobController::class, 'dairlyJob']);
        Route::get('dairlyJobrank', [CronjobController::class, 'dairlyJobrank']);
        //Route::get('RunDynamicBonus', [CronjobController::class, 'RunDynamicBonus']);
        //    Route::get('sponsorBonus', [CronjobController::class, 'sponsorBonus']);
        // Route::get('CheckRank', 'CronjobController@CheckRank');
        // Route::get('RunBonus', 'CronjobController@RunBonus');
        // Route::get('RunDynamic', 'CronjobController@RunDynamic');
    });
    Route::group(['prefix' => 'third-party'], function () {
        Route::any('reload-respond', [ThirdPartyController::class, 'reloadRespond']);
        Route::any('withdraw-respond', [ThirdPartyController::class, 'withdrawRespond']);
        Route::any('grouping-respond', [ThirdPartyController::class, 'groupingRespond']);
        Route::any('deposit', [ThirdPartyController::class, 'deposit']);
        Route::any('import-bet-record', [ThirdPartyController::class, 'importBetRecord']);
        Route::any('import-claim-record', [ThirdPartyController::class, 'importClaimRecord']);
    });

    Route::group(['prefix' => 'staking'], function () {
        Route::get('getPackageType', [StakingController::class, 'getPackageType']);

    });

    Route::group(['prefix' => 'global'], function () {
        Route::post('add_device_token', [GlobalAPIController::class, 'add_device_token']);
        Route::post('usernameOTP', [GlobalAPIController::class, 'usernameOTP']);
        Route::get('checkUsernameOtp', [GlobalAPIController::class, 'checkUsernameOtp']);
        Route::post('sent-otp', [GlobalAPIController::class, 'sentOTP']);
        Route::get('check-otp', [GlobalAPIController::class, 'checkOTP']);
        Route::get('country_list', [GlobalAPIController::class, 'country_list']);
        Route::get('lookup', [GlobalAPIController::class, 'lookup']);
        Route::post('contactUs', [GlobalAPIController::class, 'contactUs']);
    });
    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('signup', [AuthController::class, 'signup']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('reset-password', [AuthController::class, 'resetPassword']);
        Route::post('checkRefAddress', [AuthController::class, 'checkRefAddress']);
        Route::post('walletLogin', [AuthController::class, 'walletLogin']);
    });

});
// Protected routes
Route::middleware(['jwt.auth', 'preventDuplicateSubmissions'])->group(function () {
    Route::group(['prefix' => 'global'], function () {
        Route::post('add_user_device_token', [GlobalAPIController::class, 'add_device_token']);
    });

    Route::group(['prefix' => 'member'], function () {
        //special
        Route::post('registerMember', [MemberController::class, 'registerMember']);
        Route::post('bindUsername', [MemberController::class, 'bindUsername']);
        Route::post('setLanguage', [MemberController::class, 'setLanguage']);

        Route::post('updateProfile', [MemberController::class, 'updateProfile']);

        Route::post('update-member-info', [MemberController::class, 'updateMemberInfo']);
        Route::post('change-password', [MemberController::class, 'changePassword']);
        Route::post('set-secpassword', [MemberController::class, 'setSecPassword']);
        Route::post('reset-secpassword', [MemberController::class, 'resetSecPassword']);
        Route::post('change-secpassword', [MemberController::class, 'changeSecPassword']);
        Route::post('register-member', [MemberController::class, 'registerMember']);
        Route::post('user-bank', [MemberController::class, 'userBank']);
        Route::post('update-address', [MemberController::class, 'updateAddress']);
        Route::post('UserKyc', [MemberController::class, 'UserKyc']);

        Route::post('requestUserOTP', [MemberController::class, 'requestUserOTP']);
        Route::post('checkUserOTP', [MemberController::class, 'checkUserOTP']);
    });

    Route::group(['prefix' => 'staking'], function () {
        Route::post('staking', [StakingController::class, 'staking']);
        Route::get('getChangePackageType', [StakingController::class, 'getChangePackageType']);
        Route::post('changeStakingPackage', [StakingController::class, 'changeStakingPackage']);
        Route::post('renewPackage', [StakingController::class, 'renewPackage']);
        Route::post('redeemProfit', [StakingController::class, 'redeemProfit']);
        Route::post('terminateStaking', [StakingController::class, 'terminateStaking']);
    });
    Route::group(['prefix' => 'package'], function () {

        Route::post('upgrade-package', [PackageController::class, 'purchasePackage']);
        Route::post('cancelPackage', [PackageController::class, 'cancelPackage']);
        Route::post('terminatePackage', [PackageController::class, 'terminatePackage']);
        Route::post('autoRenewPackage', [PackageController::class, 'autoRenewPackage']);

    });

    Route::group(['prefix' => 'insurance'], function () {
        Route::post('purchaseInsurance', [InsuranceController::class, 'purchaseInsurance']);
        Route::post('claimInsurance', [InsuranceController::class, 'claimInsurance']);
        Route::post('surrender', [InsuranceController::class, 'surrender']);

    });

    Route::group(['prefix' => 'ticket'], function () {
        Route::post('create-ticket', [TicketController::class, 'createTicket']);
    });
    Route::group(['prefix' => 'wallet'], function () {
    });
    Route::group(['prefix' => 'chat'], function () {
        Route::post('sentChat', [ChatController::class, 'sentChat']);
    });
    Route::group(['prefix' => 'wallet'], function () {

        ///boost system
        Route::post('requestMakeDeposit', [WalletController::class, 'requestMakeDeposit']);
        ////////////////////////////////////////
        Route::post('doDeposit', [WalletController::class, 'doDeposit']);

        Route::post('doDepositCoin', [WalletController::class, 'doDepositCoin']);

        Route::post('withdraw', [WalletController::class, 'withdraw']);

        Route::post('withdrawCash', [WalletController::class, 'withdrawCash']);

        Route::post('wallet-transafer', [WalletController::class, 'walletTransfer']);
        Route::post('check-receiver', [WalletController::class, 'checkReceiver']);

        Route::post('changeWallet', [WalletController::class, 'changeWallet']);
        Route::post('depositAddress', [WalletController::class, 'depositAddress']);

    });

    Route::group(['prefix' => 'order'], function () {
        Route::post('checkOrder', [OrderController::class, 'checkOrder']);
        Route::post('boostOrder', [OrderController::class, 'boostOrder']);

    });
    Route::group(['prefix' => 'bo'], function () {
        Route::post('deposit', [BOController::class, 'deposit']);
    });
    Route::group(['prefix' => 'upload'], function () {
        Route::post('upload-file', [AttachmentController::class, 'uploadFile']);
    });
});

Route::middleware(['jwt.auth'])->group(function () {

    Route::group(['prefix' => 'member'], function () {
        //special
        Route::get('allRank', [MemberController::class, 'allRank']);

        Route::get('get-member-info', [MemberController::class, 'getMemberInfo']);
        Route::get('home-page', [MemberController::class, 'homePage']);
        Route::get('get-bank-info', [MemberController::class, 'getBankInfo']);
    });

    Route::group(['prefix' => 'project'], function () {
        Route::get('get-deposit-bank', [APIController::class, 'getDepositBank']);
    });
    Route::group(['prefix' => 'coin'], function () {
        Route::get('getBitcoinPrice', [CoinController::class, 'getBitcoinPrice']);
    });

    Route::group(['prefix' => 'staking'], function () {
        Route::get('quitRecord', [StakingController::class, 'quitRecord']);
        Route::get('investRecord', [StakingController::class, 'investRecord']);
        Route::get('getRobot', [StakingController::class, 'getRobot']);

        Route::get('getPayRecord', [StakingController::class, 'getPayRecord']);
        Route::get('stakingInfo', [StakingController::class, 'stakingInfo']);

        Route::get('getStakingRecord', [StakingController::class, 'getStakingRecord']);
    });
    Route::group(['prefix' => 'package'], function () {

        Route::get('get-upgrade-package', [PackageController::class, 'getUpgradePackage']);
        Route::get('get-package', [PackageController::class, 'getPackage']);
        Route::get('get-user-package', [PackageController::class, 'getUserPackage']);
    });

    Route::group(['prefix' => 'insurance'], function () {
        Route::get('getInsuranceHis', [InsuranceController::class, 'getInsuranceHis']);
        Route::get('getClaimInsuranceHis', [InsuranceController::class, 'getClaimInsuranceHis']);

    });

    Route::group(['prefix' => 'ticket'], function () {
        Route::get('get-ticket', [TicketController::class, 'getTicket']);
        Route::get('read-ticket', [TicketController::class, 'readTicket']);
    });
    Route::group(['prefix' => 'wallet'], function () {
        Route::get('getWallet', [MemberController::class, 'getWallet']);
    });
    Route::group(['prefix' => 'chat'], function () {
        Route::get('getChat', [ChatController::class, 'getChat']);
        Route::get('getChatNotification', [ChatController::class, 'getChatNotification']);
    });
    Route::group(['prefix' => 'wallet'], function () {

        ///boost system
        Route::get('checkAllowDeposit', [WalletController::class, 'checkAllowDeposit']);
        ////////////////////////////////////////
        Route::get('getDepositBank', [WalletController::class, 'getDepositBank']);
        Route::get('getDepositAddress', [WalletController::class, 'getDepositAddress']);
        Route::get('withdraw-record', [WalletController::class, 'withdrawRecord']);

        Route::get('withdrawCashRecord', [WalletController::class, 'withdrawCashRecord']);

        Route::get('wallet-tranfer-record', [WalletController::class, 'walletTransferRecord']);
        Route::get('deposit-record', [WalletController::class, 'depositRecord']);
        Route::get('boDepositRecord', [WalletController::class, 'boDepositRecord']);

    });

    Route::group(['prefix' => 'team'], function () {
        Route::get('downline-new', [TeamController::class, 'downlineNew']);
        Route::get('checkDownlineInfo', [TeamController::class, 'checkDownlineInfo']);
        Route::get('teamInfo', [TeamController::class, 'teamInfo']);
        Route::get('organize', [TeamController::class, 'organize']);
    });

    Route::group(['prefix' => 'record'], function () {
        Route::get('wallet-record', [RecordController::class, 'walletRecord']);
        Route::get('bonus-record', [RecordController::class, 'bonusRecord']);
        Route::get('getFinanceReport', [RecordController::class, 'getFinanceReport']);
    });

});
