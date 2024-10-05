<?php

require __DIR__ . '/../../vendor/composer/autoload.php';

use \Interview\CommissionTask\Service\private_lib\CSVTransactionFile;
use \Interview\CommissionTask\Service\models\TransactionOperation;

$config = require __DIR__ . '/config/config.ini.php';

$csvTransactionFile = new CSVTransactionFile();

$transactions = $csvTransactionFile->readFile('example');

$transactionsFees = TransactionOperation::calculateTransactions($transactions);

foreach ($transactionsFees as $transactionFee) {
    echo $transactionFee.PHP_EOL;
}
