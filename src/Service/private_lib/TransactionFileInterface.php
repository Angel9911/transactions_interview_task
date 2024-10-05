<?php

namespace Interview\CommissionTask\Service\private_lib;

use Interview\CommissionTask\Service\models\Customer;
use Interview\CommissionTask\Service\models\Transaction;

interface TransactionFileInterface
{
    function readFile($fileName);
    function getCustomerDataFromFile($id, $accountType): Customer;
    function getTransactionDataFromFile(Customer $customer, $paymentOperation, $amount, $currency, $date): Transaction;
}