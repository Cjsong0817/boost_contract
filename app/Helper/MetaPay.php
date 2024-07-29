<?php
namespace App\Helper;

use App\Models\ThirdpartyLog;
use App\Models\UserWallet;
use Carbon\Carbon;

class MetaPay
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
            'link' => 'https://pg.finio.io' . $link,
            'send_data' => json_encode($data),
            'platform' => 'metapay',
        ]);

        $data_string = json_encode($data);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://pg.finio.io' . $link,
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
    public static function getAddress($uid = 99999)
    {
        $wallet = UserWallet::where('user_id', $uid)->first();
        if (!$wallet) {
            if (config('app.env') == 'production') {
                $body['coinType'] = 2;
                $body['merchantId'] = '4';
            } else {
                $body['merchantId'] = '3';
                $body['coinType'] = 1;
            }
            $body['userid'] = $uid;
            $body['callUrl'] = url('api/third-party/reload-respond');

            //{"merchantId":1,"chain_id": 2,"userid":1,"mainCoinType":12,"address": "0x22ffee9d5e2a0ed6d510ab0debd075c436063b30"}
            $data['nonce'] = rand();
            $data['timestamp'] = Carbon::now()->timestamp;
            $data['body'] = json_encode($body);
            $data['sign'] = static::sign($data['body'], $data['nonce'], $data['timestamp']);
            $return = static::connect('/api/wallet.address/generateAll', $data);
            if (isset($return->code) && $return->code == 1) {
                $test = (array) $return->data;

                $new['wallet_type'] = 'bep20';
                $new['privateKey'] = null;
                $new['address'] = $test[$body['coinType']];
                $new['hexAddress'] = null;
                $new['user_id'] = $uid;
                $wallet = UserWallet::create($new);
                $address = $wallet->address;
            } else {
                $address = '';
            }

        } else {
            $address = $wallet->address;
        }

        return $address;
    }

    public static function sign($body, $nonce, $timestamp, $secure_key = 'nTP6CBsFqMQg28IK7VZ1r0SlYzxjw35G')
    {
        if (config('app.env') == 'production') {

            $secure_key = '0CJpbzcRhX4I1YkSVlfiu8BAywOQ5N2H';
        } else {
            $secure_key = 'nTP6CBsFqMQg28IK7VZ1r0SlYzxjw35G';
        }
        // echo $body . $secure_key . $nonce . $timestamp;
        return md5($body . $secure_key . $nonce . $timestamp);
    }

}
