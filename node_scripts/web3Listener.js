const Web3 = require('web3');

// 连接到以太坊节点（可以是本地节点或远程节点，如 Infura）
const web3 = new Web3(new Web3.providers.HttpProvider('https://etherscan.cardona.zkevm-rpc.com'));

// 要监听的交易哈希
const txHash = process.argv[2]; // 从命令行参数中获取交易哈希

async function checkTransactionStatus(txHash) {
    try {
        // 获取交易收据
        const receipt = await web3.eth.getTransactionReceipt(txHash);

        if (receipt) {
            console.log('Transaction Receipt:', receipt);

            if (receipt.status) {
                console.log('Transaction was successful');
            } else {
                console.log('Transaction failed');
            }
        } else {
            console.log('Transaction is still pending...');
        }
    } catch (error) {
        console.error('Error fetching transaction receipt:', error);
    }
}

// 轮询检查交易状态
setInterval(() => {
    checkTransactionStatus(txHash);
}, 5000); // 每5秒检查一次
