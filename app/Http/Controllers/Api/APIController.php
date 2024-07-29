<?php
namespace App\Http\Controllers\Api;

use App\Helper\Bonus;
use App\Helper\CryptedPay;
use App\Helper\MetaPay;
use App\Helper\Robot;
use App\Http\Controllers\Controller;
use App\Models\GlobalSetting;
use App\Models\GroupingRecord;
use App\Models\InsuranceHis;
use App\Models\RequestFollow;
use App\Models\SystemBank;
use App\Models\Uall;
use App\Models\User;
use App\Models\UserGroup;
use App\Models\UserInvest;
use App\Models\UserInvestRec;
use App\Models\UserPackage;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

//project model//
class APIController extends Controller
{
    public function test(Request $request)
    {
        $userId = 1000000;

        exit;
        $userinvest = UserInvest::where('id', 67)->first();
        dump($chart->roi);
        exit;
        $variable = 'daniel2';
        echo $this->containsChinese($variable);
        exit;
        $user = User::where('id', '=', 1000003)->first();
        return $user;
        exit;
        $contractAddress = '0xEBCFEE63c132D6a6e38d8f4BF7a32dD810137ABa';
        // $contractAddress = '0x87Fafd9Ff2086D9A65e22F9a7029695cC81dC948';

        $toAddress = '0xfc6a4d842150b9375148662b9B5DD5874d50982F';
        $privateKey = '2bb28709fd79f5de921f9c1bb45a2bf55769dc65907bcfe04de080b1426f4b39';

        $usdt = '0xfd94a46c03226c79f4d118e1255c5364eedf2020';
        $btc = '0x36ae3e6c3b53561f1ca983f1e27ca7ec015e61b2';
        $users = UserInvestRec::where('action_type', '=', 2)->where('grouping', '=', 0)->where('pay_type', '=', 'point2')->get();
        $total_coin = UserInvestRec::where('action_type', '=', 2)->where('grouping', '=', 0)->where('pay_type', '=', 'point2')->sum('pay');
        $idString = $users->pluck('id')->implode(',');
        dump($idString);
        if ($total_coin > 0) {
            $tmp = app('App\Http\Controllers\Api\Web3ContractController')->batchWithdrawToken($btc, $contractAddress, $privateKey, $toAddress);
            var_dump($tmp);
            if (isset($tmp->result)) {
                UserInvestRec::where('action_type', '=', 2)->where('grouping', '=', 0)->where('pay_type', '=', 'point2')->update(['grouping' => 1]);
                GroupingRecord::create([
                    'user_invest_rec_id' => $idString,
                    'total_amount' => $total_coin,
                    'pay_type' => 'point2',
                    'txid' => $tmp->result,
                ]);
            }

        }

        exit;

        // 获取 ID 小于 20 的用户

// 将用户 ID 转换为逗号分隔的字符串

        exit;

        $uid = 1000061;
        $all = Bonus::get_level($uid, 999999);
        dump($all);
        $user = User::wherein('id', $all)->get();

        exit;
        $user = User::where('id', '=', 1000003)->first();
        $userPackage = UserInvest::where('id', '=', 125)->first();

        dump(Robot::login($userPackage));exit;
        $userPackage = UserInvest::where('id', '=', 124)->first();
        dump($userPackage->penalty);exit;
        $r['user_id'] = $userPackage->user_id;
        $r['roi'] = $userPackage->roi;
        if ($userPackage->pay_type = 'point2' && $userPackage->package_type_id > 1) {
            $GLOBAL = GlobalSetting::where('global_key', 'BTC_PRICE')->first();
            $r['pay'] = $userPackage->pay;
            $btc_price = $GLOBAL->key_value;

            $fee = 10;
            $now_value = ($r['pay'] - ($r['pay'] * $fee / 100)) * $btc_price;

            if ($userPackage->price >= 10 && $userPackage->price < 3000) {
                $today_rate = 'rate1';
            } else if ($userPackage->price >= 3000 && $userPackage->price < 5000) {
                $today_rate = 'rate2';
            } else {
                $today_rate = 'rate3';
            }

            $package = Db::table("package_type")->where('id', 1)->first();

            $rate = $package->$today_rate;
            $roiFromPrice = $userPackage->price * $rate / 100;

            $coverRoi = $roiFromPrice * $userPackage->profit_day;

            $r['fee'] = $r['pay'] * $fee / 100;
            $r['pay_after_fee'] = $r['pay'] - $r['fee'];
            $r['feerate'] = 10;
            $r['now_value'] = $now_value;
            $r['total_profit'] = $userPackage->total_profit;
            $r['coverRoi'] = $coverRoi;
            $r['btc_price'] = $btc_price;
            $r['refund_usdt'] = ($now_value - $userPackage->total_profit + $coverRoi);
            $r['refund_btc'] = $r['refund_usdt'] / $btc_price;
        } elseif ($userPackage->pay_type = 'point' && $userPackage->package_type_id > 1) {
            $r['pay'] = $userPackage->pay;

            $fee = 10;
            $now_value = ($r['pay'] - ($r['pay'] * $fee / 100)) * $btc_price;

            if ($userPackage->price >= 10 && $userPackage->price < 3000) {
                $today_rate = 'rate1';
            } else if ($userPackage->price >= 3000 && $userPackage->price < 5000) {
                $today_rate = 'rate2';
            } else {
                $today_rate = 'rate3';
            }

            $package = Db::table("package_type")->where('id', 1)->first();

            $rate = $package->$today_rate;
            $roiFromPrice = $userPackage->price * $rate / 100;

            $coverRoi = $roiFromPrice * $userPackage->profit_day;

            $r['fee'] = $r['pay'] * $fee / 100;
            $r['pay_after_fee'] = $r['pay'] - $r['fee'];
            $r['feerate'] = 10;
            $r['now_value'] = $now_value;
            $r['total_profit'] = $userPackage->total_profit;
            $r['coverRoi'] = $coverRoi;
            $r['btc_price'] = 0;
            $r['refund_usdt'] = ($now_value - $userPackage->total_profit + $coverRoi);
            $r['refund_btc'] = 0;
        }
        dump($r);

        /* if (config('app.env') == 'production') {
        $contractAddress = '0xCeeb45A5CEaF9903B29700F9E105D97B295Ab8F4'; // production withdraw contract
        $privateKey = '2bb28709fd79f5de921f9c1bb45a2bf55769dc65907bcfe04de080b1426f4b39';

        $usdt = '0x55d398326f99059fF775485246999027B3197955';
        $btc = '0x7130d2A12B9BCbFAe4f2634d864A1Ee1Ce3Ead9c';
        $ABIJsonbtc = 'BTCabi.json';
        $ABIJsonusdt = 'USDTabi.json';
        } else {
        $contractAddress = '0xF121a97a91e449694E2263247f58EAff1130F2Da';
        $privateKey = '44b1c34b043d9870a140765e15c4acc8cad3e21ca291396ca7e4d217300a4dac';

        $usdt = '0xfd94a46c03226c79f4d118e1255c5364eedf2020';
        $btc = '0x36ae3e6c3b53561f1ca983f1e27ca7ec015e61b2';
        $ABIJsonbtc = 'testUSDTabi.json';
        $ABIJsonusdt = 'testUSDTabi.json';
        }
        $withdraAddress = $this->global_key('WITHDRAW_ADDRESS');

        $ABIJson = $ABIJsonusdt;
        $refund = 10;
        $balance = app('App\Http\Controllers\Api\Web3Controller')->getBalance($usdt, $withdraAddress, $ABIJson);
        dump($balance);
        if ($refund > $balance) {
        return $this->jsonResponse([
        'code' => 1,
        'message' => '钱包代币余额不足',
        ]);
        }
        $testaddress = '0xfc6a4d842150b9375148662b9B5DD5874d50982F';
        $token = $usdt;
        $decimal = 18;
        $amount = bcmul(1, pow(10, $decimal));
        $txid = app('App\Http\Controllers\Api\Web3Controller')->withdraw($testaddress, $refund, $token, $contractAddress, $privateKey);
        dump($txid);
         */
        exit;

        // 获取昨天的开始时间（零点）
        $yesterdayStart = Carbon::yesterday()->startOfDay();

// 获取今天的开始时间（零点）
        $todayStart = Carbon::now()->startOfDay();

// 计算从昨天的零点到今天的零点经过的秒数
        $secondsPassed = $todayStart->timestamp - $yesterdayStart->timestamp;

// 打印结果
        echo $secondsPassed;

        $record['get_second'] = $secondsPassed;
        dump($record);exit;
        $yesterday = Carbon::parse(Carbon::now()->subDays(1)->format('Y-m-d 23:59:59'));

        echo $yesterday->toDateString();
        $user = User::where('id', '=', 1000001)->first();
        $dateString = $user->created_at;

        // 使用 Carbon 的 parse 方法将字符串转换为 Carbon 对象
        $yourDate = Carbon::parse($dateString);

        // 获取当前时间
        $now = Carbon::now();

        // 获取计算日期的日期部分
        $datePart = $yourDate->toDateString();

        // 获取计算日期的时间部分
        $timePart = $yourDate->format('H:i:s');

        // 使用零点作为默认开始时间
        $startTime = Carbon::parse('00:00:00');

        // 如果日期是今天，则使用计算日期的时间作为开始时间
        if ($datePart === $now->toDateString()) {
            $startTime = Carbon::parse($timePart);
        }

        // 计算从开始时间到现在经过的秒数
        $secondsPassed = $now->diffInSeconds($startTime);
        dump($secondsPassed);
        exit;

        $metapay = new MetaPay();
        dump($metapay->getAddress(14));
        exit;
        $sendCloud->mailTemplate($user, 10, 'kyc_approve');
        $sendCloud->mailTemplate($user, 10, 'forget_password');
        $sendCloud->mailTemplate($user, 10, 'welcome');
        exit;
        $RequestFollow = RequestFollow::where('id', 44)->first();

        $UserPackage = UserPackage::where([['user_id', '=', $RequestFollow->user_id],
            ['status', '=', 1]])->first();
        if (!$UserPackage) {
            return Response::json(array(
                'success' => false,
                'message' => 'INCORRECT_PACKAGE',
            ));
        }

        if ($RequestFollow->request_type == 'follow') {
            $user = User::where('id', $RequestFollow->user_id)->first();
            $insurance_his = InsuranceHis::where([
                ['user_id', '=', $user->id],
                ['user_package_id', '=', $UserPackage->id],
            ])->whereDate('created_at', '=', Carbon::today()->toDateString())->first();
            $pendingClaim = ClaimInsurance::where([
                ['user_id', '=', $user->id],
                ['status', '=', 0],
            ])->first();
            dump($insurance_his);
            dump($pendingClaim);
            if (!$insurance_his && !$pendingClaim) {
                $pay = $UserPackage->package->insurance_pay * 14;
                if ($user->point3 < $pay) {
                    return $this->jsonResponse([
                        'code' => 2,
                        'data' => false,
                        'message' => 'Insufficient Trade Wallet for 14 days premiums',
                    ]);
                }
                dump($pay);
            }
        }
        dump(config('app.env'));
        // Binaxtion::follow_unfollow('account', 100, 'follow');
        exit;

        $user = User::where('id', '=', 1000001)->first();
        //  dump(Binaxtion::pull_capital('zx111222')); //
        exit;
        // $this->smtp_mail('philiplim0928@gmail.com', 'Otp', 'Dear <br>Your OTP is 123');
        exit;
        return CryptedPay::withdraw('12131saca', 'ref', 1); //
        exit;

        exit;
        //Binaxtion::deposit('ibo', 100);

        $package = UserGroup::where('display', 1)->where('id', '=', 2)->first();
        Bonus::level_bonus(100, $user->id);
        exit;

        echo $user->check_cap(2000, 'matching');
        exit;
        //$this->introduce();
        $hour = Carbon::now()->format('H');

        // smtp_mail('philipli222m0928@gmail.com', 'Otp', 'Dear ' . $user->username . '.<br>Your OTP is 123');

        //  return $this->sendMail2('philiplim0928@gmail.com', 'Otp', 'Dear ' . $user->username . '.<br>Your OTP is 123');

        $base = 100;
        //     $r = Bonus::sponsor_bonus($base, $user->id);
        //    $r = Bonus::dynamic_bonus($base, $user->id);
        //return $user->checkDownline(1000045,'j');
        //DB::select('call sendBV("' . $user->id . '","' . (int)$user->package->bv . '")');
        // $r = $user->pushMobileNotification('diam7!', 'sohai la you!', 'Creator application approved');

        // $r = Bonus::single_static_bonus(1000007);
        //return $r;
    }
    public function introduce()
    {

        $list = User::where('id', '>', "99998")->get();

        for ($i = 0; $i < count($list); $i++) {

            $jie = Uall::where("user_id", $list[$i]->pid)->first();
            if ($jie) {

                $array = explode(",", $jie->p);
                array_shift($array);
                array_unshift($array, $list[$i]->pid);
                $data['p'] = "0," . implode(",", $array);
                Uall::where("user_id", $list[$i]->id)->update($data);
                echo $list[$i]->pid . ',';
            }
        }
        //$this->setplevel();
    }
    public function setplevel()
    {
        $list = M('users')->where('uid >99999')->select();
        for ($i = 0; $i < count($list); $i++) {
            $p = M('users')->where('uid=' . $list[$i]['pid'])->find();
            $data['plevel'] = $p['plevel'] + 1;
            M('users')->where('uid=' . $list[$i]['uid'])->save($data);
        }
    }
    /**
     * @OA\GET(
     *     path="/api/project/get-deposit-bank",
     *     tags={"Project"},
     *     summary="getDepositBank",
     *     description="get deposit bank",
     *     operationId="getDepositBank",
     *      security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="country_id",
     *         in="query",
     *         description="country_id",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error"
     *     )
     * )
     */
    public function getDepositBank(Request $request)
    {

        $user = auth()->user();
        if ($request->get('country_id')) {
            $record = SystemBank::where('is_display', 1)->where('bank_country', $request->get('country_id'))->orderBy('id', 'desc')->get();
        } else {
            $record = SystemBank::where('is_display', 1)->orderBy('id', 'desc')->get();
        }

        return $this->jsonResponse([
            'code' => 0,
            'data' => [
                'system_bank' => $record,
            ],
            'message' => '',
        ]);
    }

}
