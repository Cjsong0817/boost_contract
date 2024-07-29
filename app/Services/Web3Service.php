<?php

namespace App\Services;

use Web3\Contract;
use Web3\Providers\HttpProvider;
use Web3\RequestManagers\HttpRequestManager;
use Web3\Web3;

class Web3Service
{
    protected $web3;
    protected $contract;

    public function __construct()
    {
        $provider = new HttpProvider(new HttpRequestManager('https://cardona-zkevm.polygonscan.com/', 2442));
        $this->web3 = new Web3($provider);

        $abi = json_decode(file_get_contents(storage_path('contract/BoostProtocol.json')), true);
        $this->contract = new Contract($provider, $abi);
    }

    public function callFunction($functionName, $params = [])
    {
        $contractAddress = '0xEF05CC5Bf045d1876A0bd9e43784c62143c32DcF';
        $this->contract->at($contractAddress)->call($functionName, $params, function ($err, $result) {
            if ($err !== null) {
                throw new \Exception($err->getMessage());
            }

            return $result;
        });
    }

    public function sendTransaction($functionName, $params = [], $from, $privateKey)
    {
        $contractAddress = '0xEF05CC5Bf045d1876A0bd9e43784c62143c32DcF';

        $this->contract->at($contractAddress)->send($functionName, $params, [
            'from' => $from,
            'gas' => '0x76c0', // 30400
            'gasPrice' => '0x9184e72a000', // 10000000000000
        ], $privateKey, function ($err, $transaction) {
            if ($err !== null) {
                throw new \Exception($err->getMessage());
            }

            return $transaction;
        });
    }
}
