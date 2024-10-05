<?php

namespace Interview\CommissionTask\Service\private_lib;

use InvalidArgumentException;
use Interview\CommissionTask\Service\models\BusinessCustomer;
use Interview\CommissionTask\Service\models\Customer;
use Interview\CommissionTask\Service\models\PrivateCustomer;
use Interview\CommissionTask\Service\models\Transaction;
use Interview\CommissionTask\Service\validators\Validation;

class CSVTransactionFile implements TransactionFileInterface
{
    /**
     * Read file and return array of transactions
     * @param $fileName
     * @param string $fileType
     * @return array
     */
    public function readFile($fileName, string $fileType = '.csv'): array
    {
        $transactions = array();

        if(($handle = fopen($GLOBALS['config']['path_to_file'].$fileName.$fileType, 'r')) !== false){

            while (($data = fgets($handle,1000)) !== false){

                $line = trim($data);

                $data = explode("\t", $line);

                $arrayTransaction = explode(";", $data[0]);

                $convertTransaction = [
                    'date' => $arrayTransaction[0],
                    'id' => $arrayTransaction[1],
                    'account_type' => $arrayTransaction[2],
                    'operation_type' => $arrayTransaction[3],
                    'amount' => $arrayTransaction[4],
                    'currency' => $arrayTransaction[5],
                ];

                if(Validation::validateAsDate($convertTransaction['date'])
                    && Validation::validateAsCurrency($convertTransaction['currency'])
                    && Validation::validateAsAccountType($convertTransaction['account_type'])
                    && Validation::validateAsOperationType($convertTransaction['operation_type'])){

                    $customer = $this->getCustomerDataFromFile($convertTransaction['id'], $convertTransaction['account_type']);

                    $transaction = $this->getTransactionDataFromFile($customer, $convertTransaction['operation_type'], $convertTransaction['currency'], $convertTransaction['amount'], $convertTransaction['date']);

                    $transactions[] = $transaction;
                }
            }

            fclose($handle);
        }

        return $transactions;
    }

    /**
     * Return customer object by passing id and accountType
     * @param $id
     * @param $accountType
     * @return Customer
     */
    public function getCustomerDataFromFile($id, $accountType): Customer
    {
        if($accountType === 'private'){

            return new PrivateCustomer($id);
        } else if($accountType === 'business'){

            return new BusinessCustomer($id);
        }

        throw new InvalidArgumentException("Invalid account type: $accountType");
    }

    /**
     * Return transaction object by passing following parameters
     * @param Customer $customer
     * @param $paymentOperation
     * @param $amount
     * @param $currency
     * @param $date
     * @return Transaction
     */
    public function getTransactionDataFromFile(Customer $customer, $paymentOperation, $amount, $currency, $date): Transaction
    {

        return new Transaction($customer,$paymentOperation,$amount,$currency, $date);
    }
}