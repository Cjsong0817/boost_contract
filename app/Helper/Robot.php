<?php
namespace App\Helper;

use App\Models\InvestRobot;
use App\Models\ThirdpartyLog;
use Carbon\Carbon;

class Robot
{

    public static function connect($link, $data)
    {
        if (auth()->user()) {
            $user_id = auth()->user()->id;
        } else {
            $user_id = 0;
        }
        $log = ThirdpartyLog::create([
            'user_id' => $user_id,
            'link' => $link,
            'send_data' => json_encode($data),
            'platform' => 'robot',
        ]);

        $data_string = json_encode($data);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $link,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                'X-AjaxPro-Method:TradeRest',
                "accept: */*",
                'Content-Type: application/json; charset=utf-8',
                'Content-Length: ' . strlen($data_string),
            ),
        ));

        $response = curl_exec($curl);

        $log->respond_data = $response;
        $log->save();
        $err = curl_error($curl);
        curl_close($curl);
        return json_decode($response);

    }

    public static function registerRobot($userinvest)
    {
        /*
        parameters : username , email , join_date , staking
        staking value : Flexi Staking , 180 , 360
        return : member_code , password*/
        if ($userinvest->package_type_id == 1) {
            $staking = 'Flexi Staking';
        } elseif ($userinvest->package_type_id == 2) {
            $staking = 180;
        } else {
            $staking = 360;
        }
        $data['username'] = $userinvest->user->username;
        $data['staking'] = $staking;
        $data['email'] = $userinvest->user->email;
        $data['join_date'] = Carbon::parse($userinvest->created_at)->format('Y-m-d');
        $return = static::connect('https://aurionpro.finio.io/api/register', $data);

        if (isset($return->data->member_code)) {
            $conditions = ['user_invest_id' => $userinvest->id];
            $data = ['member_code' => $return->data->member_code, 'password' => $return->data->password];

            // 根据条件查找记录，如果找到则更新，找不到则创建新记录
            $robot = InvestRobot::updateOrCreate($conditions, $data);
        } else {
            $robot = null;
        }

        return $robot;
    }
    public static function login($userinvest)
    {
        $robot = InvestRobot::where('user_invest_id', $userinvest->id)->first();
        if (!$robot) {
            $robot = static::registerRobot($userinvest);

        }
        if ($robot) {
            $link = 'https://aurionpro.finio.io/login/autologin/' . $robot->member_code;
        } else {
            $link = null;
        }

        return $link;
    }
    public static function getSignature($data)
    {
        $key = "M3eH4562MsieVbjlS1JfkF2EmVw7kWLb";
        ksort($data);
        return strtoupper(md5(md5(http_build_query($data)) . $key));
    }

    public static function create_transaction($user_id, $act, $wallet, $found_type, $wallet_type, $amount, $detail, $detailen, $detailvn = '', $detailin = '', $detailth = '', $remark = '')
    {
        $user = User::where('id', $user_id)->first();

        if (!$user) {
            return response()->json(false);
        }

        if ($amount < 0) {
            return response()->json(false);
        }

        if ($act == '+') {
            $add['current'] = $user->$wallet + $amount;
            $add['in_type'] = $wallet_type;

        } else {
            $add['current'] = $user->$wallet - $amount;
            $add['out_type'] = $wallet_type;
        }
        if ($add['current'] < 0) {
            return response()->json(false);
        }

        $add['previous'] = $user->$wallet;
        $add['action'] = $act;
        $add['user_id'] = $user_id;
        $add['found_type'] = $found_type;
        $add['found'] = $amount;
        $add['detail'] = $detail;
        $add['detailen'] = $detailen;
        $add['detailth'] = $detailth;
        $add['detailvn'] = $detailvn;
        $add['detailin'] = $detailin;
        $add['remark'] = $remark;
        $add['created_at'] = date("Y-m-d h:i:s");

        $r = DB::table('users')->where('id', $user_id)->update([$wallet => $add['current']]);
        $r = FundTransfer::create($add);
        return 1;
    }
}
