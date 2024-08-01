<?php

namespace App\Services;

use Web3\Contract;
use Web3\Providers\HttpProvider;
use Web3\RequestManagers\HttpRequestManager;
use Web3\Utils;
use Web3\Web3;

class Web3Service
{
    protected $web3;
    protected $contract;
    protected $owner_address;
    protected $privateKey;

    public function __construct()
    {
        $this->owner_address = '0xfc6a4d842150b9375148662b9B5DD5874d50982F';
        $this->privateKey = '44b1c34b043d9870a140765e15c4acc8cad3e21ca291396ca7e4d217300a4dac';

        $provider = new HttpProvider(new HttpRequestManager('https://etherscan.cardona.zkevm-rpc.com/', 2442));
        $this->web3 = new Web3($provider);

        $abi = json_decode(file_get_contents(storage_path('contract/BoostProtocol.json')), true);
        $this->contract = new Contract($provider, $abi['abi']);
    }

    public function callFunction($functionName, $params = [])
    {
        $contractAddress = '0xEF05CC5Bf045d1876A0bd9e43784c62143c32DcF';
        $this->contract->at($contractAddress)->call($functionName, $params, function ($err, $result) use ($functionName) {
            if ($err !== null) {

                throw new \Exception($err->getMessage());
            }
            dump($result);
            $respond['data'] = null;
            if ($functionName == 'getPrice') {

                $bigInteger = $result[0];
                $weiValue = $bigInteger->toString();

                $etherArray = Utils::fromWei($weiValue, 'ether');

                $integerPart = $etherArray[0]->toString();
                $decimalPart = $etherArray[1]->toString();
                $ether = $integerPart . '.' . str_pad($decimalPart, 18, '0', STR_PAD_LEFT);
                $respond['data'] = $ether;
            }

            //  $ether = Utils::fromWei($wei, 'ether');
            return $respond;
        });
    }

    public function sendTransaction($functionName, $params = [])
    {
        $contractAddress = '0xEF05CC5Bf045d1876A0bd9e43784c62143c32DcF';

        $this->contract->at($contractAddress)->send($functionName, $params, [
            'from' => $this->owner_address,
            'gas' => '0x76c0', // 30400
            'gasPrice' => '0x9184e72a000', // 10000000000000
        ], $this->privateKey, function ($err, $transaction) {
            if ($err !== null) {
                throw new \Exception($err->getMessage());
            }

            return $transaction;
        });
    }
}
