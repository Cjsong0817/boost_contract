<?php
namespace App\Helper;

use Web3\Web3;

class web3Contract
{
    protected $web3;
    protected $contract;

    public function __construct(string $nodeUrl, string $contractAddress, array $contractAbi)
    {
        $this->web3 = new Web3($nodeUrl);
        $this->contract = $this->web3->eth->contract($contractAbi)->at($contractAddress);
    }

    public function computeAddress(string $someParameter): string
    {
        // 调用 computeAddress 函数
        $result = $this->contract->computeAddress($someParameter);

        // 返回结果
        return $result->toString();
    }

    public function generateSender($contractAddress, $userid)
    {
        $ethers = EthereumRPC::provider($this->node);
        $contractAddress = '0xF121a97a91e449694E2263247f58EAff1130F2Da';
        $contract = $ethers->getContract($this->abi, $contractAddress);
        $someParameter = 123;
        $result = $contract->send('computeAddress', [$someParameter]);

        // 打印结果
        echo "Computed Address: " . $result->get() . PHP_EOL;

    }
    public function testwithdraw($contract, $token, $fromid, $amount, $toadderss, $cb)
    {
        try {
            $this->contract->at($contract);
            $this->contract->call("transferToken", $beginid, $maxid, $minamount, $cb);
        } catch (Exception $e) {
            return call_user_func($cb, $e, null);
        }
    }
}
