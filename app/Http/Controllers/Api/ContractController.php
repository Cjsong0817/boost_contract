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
        $result = $this->web3Service->callContractFunction('totalUsdt');
        return response()->json($result);
    }

    public function sendTransaction(Request $request)
    {
        $result = $this->web3Service->sendTransaction('yourFunctionName', [$request->param1, $request->param2], 'your_wallet_address', 'your_private_key');
        return response()->json($result);
    }
}
