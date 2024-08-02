<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Web3Service;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    protected $web3Service;

    public function __construct(Web3Service $web3Service)
    {
        $this->web3Service = $web3Service;
    }

    public function getContractData()
    {
        //totalPledge = 总质押

        $data = '238';
        $result = $this->web3Service->callFunction('getUserAddr', $data);
        dump($result);
        return $result;
    }
    public function getTotalPledge()
    {
        //getPrice = boost value
        $data = [];
        $result = $this->web3Service->callFunction('totalPledge', $data);
    }
    public function getUserAddress()
    {
        $data = '238';
        $result = $this->web3Service->callFunction('getUserAddr', $data);
    }
    public function getMarketPrice()
    {
        //getPrice = boost value
        $data = [];
        $result = $this->web3Service->callFunction('getPrice', $data);
    }
    public function sendTransaction(Request $request)
    {
        $data = [1000000]; //[$request->param1, $request->param2]
        $result = $this->web3Service->sendTransaction('systemPledge', $data);
        return response()->json($result);
    }
}
