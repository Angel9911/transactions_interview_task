<?php

namespace Interview\CommissionTask\Service\private_lib;

use DateTime;
use Interview\CommissionTask\Service\validators\TransactionOperationConstraints;

/**
 * Class handles with the main logic of the system. Calculation of fees for given transactions
 */
class TransactionOperation
{
    static array $withdrawals = [];

    /**
     * Calculate the transaction fee based on whether the transaction is withdrawal or deposit
     * @param array $transactions
     * @return array
     */
    public static function calculateTransactions(array $transactions): array
    {
        $transactionsFees = [];

        self::$withdrawals = [];

        if(!empty($transactions)){

            foreach ($transactions as $transaction) {

                $transactionsFee = 0;

                if($transaction->getOperation() === 'withdraw') {

                    $transactionsFee = self::calculateWithdrawTransaction($transaction->getCustomer()->getId(),$transaction->getCustomer()->getAccountType(),$transaction->getAmount(),$transaction->getCurrency(), $transaction->getDate());
                }
                if($transaction->getOperation() === 'deposit') {

                    $transactionsFee = self::calculateDepositTransaction($transaction->getAmount());
                }

                $transactionsFees[] = $transactionsFee;
            }
        }

        return $transactionsFees;
    }

    /**
     * Calculating of deposit transaction fee
     * @param $amount
     * @return string
     */
    private static function calculateDepositTransaction($amount): string
    {
        $fee = $amount * TransactionOperationConstraints::depositCommissionFee;

        return self::roundUpNumber($fee);
    }

    /**
     * Calculating of withdraw transaction fee
     * @param int $customerId
     * @param string $accountType
     * @param $amount
     * @param $currency
     * @param $date
     * @return float|int|string
     */
    private static function calculateWithdrawTransaction(int $customerId, string $accountType, $amount, $currency, $date): float|int|string
    {
        if($currency !== 'EUR'){

            $amount = self::convertToEUR($amount, $currency);
        }

        if($accountType === 'business') {

            $fee = $amount * TransactionOperationConstraints::withdrawBusinessCommissionFee;

            return self::roundUpNumber($fee);

        } else if($accountType === 'private') {

            list($year, $weekNumber) = self::getWeekStart($date);

            if(!isset(self::$withdrawals[$customerId])){

                self::$withdrawals[$customerId] = [];
            }
            if(!isset(self::$withdrawals[$customerId][$year][$weekNumber])){

                self::$withdrawals[$customerId][$year][$weekNumber] = [
                    'total' => 0,
                    'count' => 0
                ];
            }

            self::$withdrawals[$customerId][$year][$weekNumber]['count']++;

            $fee = self::calculatePrivateWithdraw($customerId, $year, $weekNumber, $amount);

            self::$withdrawals[$customerId][$year][$weekNumber]['total'] += $amount;

            return $fee;

        }
        return 0;
    }

    /**
     * Extracted method which calculating withdraw transaction fee
     * @param $customerId
     * @param $amount
     * @param $weeklyWithdrawals
     * @param $date
     * @return float|int
     */
    private static function calculatePrivateWithdraw($customerId, $year, $weekNumber, $amount): float|int|string
    {
        $freeLimit = 1000.00;
        $freeOperationsLimit = 3;

        $weekData = self::$withdrawals[$customerId][$year][$weekNumber];
        $currentWithdrawalsAmount =  $weekData['total'];
        $currentWeekWithdrawals = $weekData['count'];

        if($currentWeekWithdrawals > $freeOperationsLimit) {

            $fee = $amount * TransactionOperationConstraints::withdrawPrivateCommissionFee;
            return self::roundUpNumber($fee);
        }

        if($currentWithdrawalsAmount >= $freeLimit) {

            $fee = $amount * TransactionOperationConstraints::withdrawPrivateCommissionFee;
            return self::roundUpNumber($fee);
        }

        $remainingFreeLimit2 = $freeLimit - ($currentWithdrawalsAmount + $amount);

        if($remainingFreeLimit2 >= 0){

            return 0;
        }else{

            $exceedingAmount = ($currentWithdrawalsAmount + $amount) - $freeLimit;

            $fee = $exceedingAmount * TransactionOperationConstraints::withdrawPrivateCommissionFee;

            return self::roundUpNumber($fee);
        }
    }

    /**
     * Round up the number to bigger one
     * @param $number
     * @return string
     */
    private static function roundUpNumber($number): string
    {
        $rvalue = round($number,2);

        return number_format($rvalue, 2, '.', '');
    }

    /**
     * Return year and week data, to determine when the transaction is created
     * @param $date
     * @return array
     * @throws \DateMalformedStringException
     */
    private static function getWeekStart($date): array
    {
        $dateTime = new DateTime($date);

        $numberWeek = intval(date('W',$dateTime->getTimestamp()));
        $year  = date('o',$dateTime->getTimestamp());

        return [$year,$numberWeek];
    }

    /**
     * Convert the amount in EUR by given currency. The currencies and rates are hardcoded.
     * @param $amount
     * @param $currency
     * @return float
     */
    private static function convertToEUR($amount, $currency): float
    {
        $exchangeRates = [
            'USD' => 0.85,
            'GBP' => 1.15,
            'JPY' => 0.0076,
        ];

        $rate = $exchangeRates[$currency];

        return $amount * $rate;
    }
}