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
        //getPrice = boost value
        $data = [1000000];
        $result = $this->web3Service->callFunction('getuseraddr', $data);
        return $result;
    }

    public function sendTransaction(Request $request)
    {
        $data = [1000000]; //[$request->param1, $request->param2]
        $result = $this->web3Service->sendTransaction('create', $data, 'your_wallet_address', 'your_private_key');
        return response()->json($result);
    }
}
