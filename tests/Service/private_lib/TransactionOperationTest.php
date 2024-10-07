<?php

namespace Interview\Tests\Service\private_lib;

use Interview\CommissionTask\Service\models\BusinessCustomer;
use Interview\CommissionTask\Service\models\PrivateCustomer;
use Interview\CommissionTask\Service\models\Transaction;
use Interview\CommissionTask\Service\private_lib\TransactionOperation;
use PHPUnit\Framework\TestCase;

class TransactionOperationTest extends TestCase
{
    private $privateCustomerTransactions = [];
    private $businessCustomerTransactions = [];

    public function setUp(): void
    {
        $privateCustomer = new PrivateCustomer(2);

        $privateCustomer2 = new PrivateCustomer(1);

        $businessCustomer= new BusinessCustomer(4);

        $this->privateCustomerTransactions[] = $this->generateTransaction($privateCustomer,'withdraw', 'EUR', 1200.00, '31.12.2014');
        $this->privateCustomerTransactions[] = $this->generateTransaction($privateCustomer,'withdraw', 'EUR', 1000.00, '1.1.2015');
        $this->privateCustomerTransactions[] = $this->generateTransaction($privateCustomer,'withdraw', 'EUR', 1000.00, '5.1.2016');
        $this->privateCustomerTransactions[] = $this->generateTransaction($privateCustomer2,'deposit', 'EUR', 200.00, '5.1.2016');

        $this->businessCustomerTransactions[] = $this->generateTransaction($businessCustomer,'withdraw', 'EUR', 300.00, '15.1.2015');
        $this->businessCustomerTransactions[] = $this->generateTransaction($businessCustomer,'deposit', 'EUR', 10000.00, '10.1.2016');
    }

    public function tearDown(): void
    {
        $this->privateCustomerTransactions = [];
        $this->businessCustomerTransactions = [];

    }
    public function testCalculateAllTransactions()
    {

        $allTransactions = array_merge($this->privateCustomerTransactions,$this->businessCustomerTransactions);

        $actualTransactionsFees = TransactionOperation::calculateTransactions($allTransactions);

        $expectedTransactionsFess = ['0.60', '3.00', '0', '0.06','1.50', '3.00'];

        $this->assertEquals(
            $expectedTransactionsFess,
            $actualTransactionsFees
        );

    }

    public function testCalculatePrivateCustomerTransactions()
    {

        $actualTransactionsFees = TransactionOperation::calculateTransactions($this->privateCustomerTransactions);

        $expectedTransactionsFess = ['0.60', '3.00', '0', '0.06'];

        $this->assertCount(
            count($expectedTransactionsFess),
            $actualTransactionsFees
        );
        $this->assertEquals(
            $expectedTransactionsFess,
            $actualTransactionsFees
        );
    }

    public function testCalculateBusinessCustomerTransactions()
    {
        $actualTransactionsFees = TransactionOperation::calculateTransactions($this->businessCustomerTransactions);

        $expectedTransactionsFess = ['1.50', '3.00'];

        $this->assertEquals(
            $expectedTransactionsFess,
            $actualTransactionsFees
        );
    }

    private function generateTransaction($customer, $operation, $currency, $amount, $date): Transaction
    {
        return new Transaction($customer, $operation, $currency, $amount, $date);
    }

}