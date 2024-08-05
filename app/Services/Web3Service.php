<?php

namespace App\Services;

use InvalidArgumentException;
use Web3p\EthereumTx\Transaction as Tx;
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

        $provider = new HttpProvider(new HttpRequestManager('https://etherscan.cardona.zkevm-rpc.com/'), 2442);
        $this->web3 = new Web3($provider);

        $abi = json_decode(file_get_contents(storage_path('contract/BoostProtocol.json')), true);
        $this->contract = new Contract($provider, $abi['abi']);
    }

    public function callFunction($functionName, $params)
    {

        $respond['data'] = null;
        $contractAddress = '0xEF05CC5Bf045d1876A0bd9e43784c62143c32DcF';

        $this->contract->at($contractAddress)->call($functionName, $params, function ($err, $result) use ($functionName, &$respond) {
            if ($err !== null) {
                throw new \Exception($err->getMessage());
            }

            if ($functionName == 'totalBoost') {
                $bigInteger = $result[0];
                $weiValue = $bigInteger->toString();
                $etherArray = Utils::fromWei($weiValue, 'ether');
                $integerPart = $etherArray[0]->toString();
                $decimalPart = $etherArray[1]->toString();
                $ether = $integerPart . '.' . str_pad($decimalPart, 18, '0', STR_PAD_LEFT);
                $respond['data'] = $ether;
            } elseif ($functionName == 'totalUsdt') {
                $bigInteger = $result[0];
                $weiValue = $bigInteger->toString();
                $etherArray = Utils::fromWei($weiValue, 'ether');
                $integerPart = $etherArray[0]->toString();
                $decimalPart = $etherArray[1]->toString();
                $ether = $integerPart . '.' . str_pad($decimalPart, 18, '0', STR_PAD_LEFT);
                $respond['data'] = $ether;
            } elseif ($functionName == 'getPrice') {
                $bigInteger = $result[0];
                $weiValue = $bigInteger->toString();
                $etherArray = Utils::fromWei($weiValue, 'ether');
                $integerPart = $etherArray[0]->toString();
                $decimalPart = $etherArray[1]->toString();
                $ether = $integerPart . '.' . str_pad($decimalPart, 18, '0', STR_PAD_LEFT);
                $respond['data'] = $ether;
            } elseif ($functionName == 'getUserAddr') {
                $respond['data'] = $result['account'];
            }
        });
        return $respond;
    }
    public function sendTransaction($functionName = 'systemPledge', $params = [])
    {
        $contractAddress = '0xEF05CC5Bf045d1876A0bd9e43784c62143c32DcF';
        $functionName = 'systemPledge';
        $ether = (string) 100;
        $wei = Utils::toWei($ether, 'ether');
        $this->contract->at($contractAddress);
        $params = [1000000, $wei]; // 示例数据
        $data = $this->getData($functionName, $params);

        dump($data);
        $cb = new Callback();
        $cb1 = new Callback();
        $from = $this->owner_address;
        $this->contract->getEth()->getTransactionCount($from, 'pending', $cb);
        $trans = [
            "from" => $from,
            "to" => $contractAddress,
            "gas" => "0x" . Utils::toHex("1000000"), // 30400
            "gasPrice" => "0x" . Utils::toHex(Utils::toWei("4.5", "Gwei")), // 10000000000000
            "value" => "0x0",
            "data" => $data,
            "nonce" => "0x" . $this->web3->getUtils()->toHex($cb->result->toString()),
            "chainId" => 2442,
        ];
        // $trans['nonce'] = "0x" . $this->web3->getUtils()->toHex($cb->result->toString());
        // $trans['chainId'] = $this->chain['chain_id'];
        print_r($trans);
        $transaction = new Tx($trans);
        $signTransaction = $transaction->sign($this->privateKey);
        echo "\r\n $signTransaction \r\n";
        sleep(2);
        try {
            $this->contract->at($contractAddress)->getEth()->sendRawTransaction("0x" . $signTransaction, $cb1);
            echo "TxID: $cb1->result \r\n";

            dump($this->contract);
            dump($cb1);
            echo "Transction Hash: \$cb1->result > " . $cb1->result . "\r\n";
        } catch (Exception $e) {
            dump($e->getMessage());
        }
        exit;

        $this->contract->at($contractAddress)->send(
            $functionName,
            $params,
            [
                'from' => $this->owner_address,
                'gas' => '0x76c0', // 30400
                'gasPrice' => '0x9184e72a000', // 10000000000000
            ],
            $this->privateKey,
            function ($err, $transaction) {
                if ($err !== null) {
                    throw new \Exception($err->getMessage());
                }

                return response()->json([
                    'transaction' => $transaction,
                ]);
            }
        );

    }
    public function getData($method, $params)
    {
        $functions = [];
        foreach ($this->contract->getAbi() as $item) {
            if ($item['type'] == 'function' && $item['name'] == $method) {
                $functions[] = $item;
            }
        }
        $data = "";
        $functionName = "";
        foreach ($functions as $function) {
            if (count($params) !== count($function['inputs'])) {
                continue;
            }
            try {
                $data = $this->contract->getEthabi()->encodeParameters($function, $params);
                $functionName = Utils::jsonMethodToString($function);
            } catch (InvalidArgumentException $e) {
                continue;
            }
            break;
        }
        if (empty($data) || empty($functionName)) {
            throw new InvalidArgumentException('Please make sure you have put all function params and callback.');
        }
        $functionSignature = $this->contract->getEthabi()->encodeFunctionSignature($functionName);
        $functionData = Utils::stripZero($functionSignature) . Utils::stripZero($data);
        return "0x" . $functionData;
    }
    public function sendTransactionbak($functionName = 'systemPledge', $params = [])
    {
        // 将 Ether 转换为 Wei
        $ether = (string) 100;
        $wei = Utils::toWei($ether, 'ether');

        // 确保参数数组包含必要的参数
        $data = [1000000, $wei]; // 示例数据

        $contractAddress = '0xEF05CC5Bf045d1876A0bd9e43784c62143c32DcF';

        $this->contract->at($contractAddress)->send($functionName, $data, [
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

class Callback
{

    public $error = null;

    public $result = null;

    public function __invoke($error, $result)
    {
        if ($error) {
            $this->error = $error;
        } else {
            $this->error = null;
        };
        $this->result = $result;
    }
}
