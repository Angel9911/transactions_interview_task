<?php

require __DIR__ . '/../../vendor/composer/autoload.php';

use Interview\CommissionTask\Service\private_lib\CSVTransactionFile;
use Interview\CommissionTask\Service\private_lib\TransactionOperation;

$config = require __DIR__ . '/config/config.ini.php';

$file = 'example'; // default filename

if(isset($_SERVER['argv'][1])){

    $file = $_SERVER['argv'][1];

    $fileName = explode('.', $file);

    // if the file type is CSV
    if($fileName[1] === 'csv'){

        $csvTransactionFile = new CSVTransactionFile();

        $transactions = $csvTransactionFile->readFile($fileName[0]);
    }

    if(!empty($transactions)){

        $transactionsFees = TransactionOperation::calculateTransactions($transactions);

        foreach ($transactionsFees as $transactionFee) {
            echo $transactionFee.PHP_EOL;
        }
    }
}
