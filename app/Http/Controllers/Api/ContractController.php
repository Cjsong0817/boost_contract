<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserAddress;
use App\Services\Web3Service;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    protected $web3Service;

    public function __construct(Web3Service $web3Service)
    {
        $this->web3Service = $web3Service;
    }

    public function checkTransactionStatus($txHash)
    {
        // Sanitize the transaction hash input
        $txHash = escapeshellarg($txHash);

        // Node.js script path
        $nodeScript = base_path('node_scripts/web3Listener.js');

        // Check if the Node.js script exists and is executable
        if (!file_exists($nodeScript) || !is_executable($nodeScript)) {
            return response()->json(['error' => "Node.js script not found or not executable: $nodeScript"], 500);
        }

        // Command to execute the Node.js script with the transaction hash
        $command = "node $nodeScript $txHash";

        // For debugging: Log the command to be executed
        \Log::debug("Executing command: $command");

        // Execute the command and capture the output
        $output = shell_exec($command);

        // Check if the command execution was successful
        if ($output === null) {
            // Handle the error case (e.g., script failed to run)
            return response()->json(['error' => 'Failed to execute Node.js script'], 500);
        }

        // Decode the JSON output from the Node.js script
        $outputData = json_decode($output, true);

        // Return the output to the front-end
        return response()->json($outputData);
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
    public function getUserAddress(Request $request)
    {

        $data = $request->get('user_id');
        $result = $this->web3Service->callFunction('getUserAddr', $data);
        if (isset($result['data']) && $result['data'] != null) {

            $address = UserAddress::updateOrCreate(
                ['user_id' => $user->id],
                ['wallet_type' => 'polygon', 'address' => $result['data']]
            );

        }
        $this->success($address);
    }
    public function getMarketPrice()
    {
        //getPrice = boost value
        $data = [];
        $totalusdt = $this->web3Service->callFunction('totalUsdt', $data);
        if (isset($totalusdt['data']) && $totalusdt['data'] != null) {
            $this->set_key('USDTB_POOL', $totalusdt['data']);
        }
        $totalBoost = $this->web3Service->callFunction('totalBoost', $data);
        if (isset($totalBoost['data']) && $totalBoost['data'] != null) {
            $this->set_key('BOOST_POOL', $totalBoost['data']);
        }
        $getPrice = $this->web3Service->callFunction('getPrice', $data);
        if (isset($getPrice['data']) && $getPrice['data'] != null) {
            $this->set_key('BOOST_PRICE', $getPrice['data']);
        }
    }
    public function sendTransaction(Request $request)
    {
        $data = [1000000]; //[$request->param1, $request->param2]
        $result = $this->web3Service->sendTransaction('systemPledge', $data);
        return response()->json($result);
    }
}
