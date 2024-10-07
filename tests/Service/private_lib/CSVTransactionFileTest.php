<?php

namespace Interview\Tests\Service\private_lib;

$config = require dirname(__DIR__) . '/config/config.ini.php';

use Interview\CommissionTask\Service\models\BusinessCustomer;
use Interview\CommissionTask\Service\models\PrivateCustomer;
use Interview\CommissionTask\Service\models\Transaction;
use Interview\CommissionTask\Service\private_lib\CSVTransactionFile;
use PHPUnit\Framework\TestCase;

class CSVTransactionFileTest extends TestCase
{
    private $fileName;

    private $csvTransactionFile;

    private $transactions;

    public function setUp(): void
    {
        $this->fileName = 'test';

        $this->csvTransactionFile = new CSVTransactionFile();

        $this->generateTransactions();
    }

    public function tearDown(): void
    {
        $this->transactions = [];
    }

    public function testReadFileThenReturnArray()
    {
        $actualResult = $this->csvTransactionFile->readFile($this->fileName);

        $this->assertCount(
            count($this->transactions),
            $actualResult
        );
        $this->assertEquals(
            $this->transactions,
            $actualResult
        );
    }

    private function generateTransactions()
    {
        $privateCustomer4 = new PrivateCustomer(4);
        $privateCustomer = new PrivateCustomer(1);
        $businessCustomer = new BusinessCustomer(2);

        $this->transactions[] = new Transaction($privateCustomer4,'withdraw', 'EUR', 1200.00, '2014-12-31');
        $this->transactions[] = new Transaction($privateCustomer4,'withdraw', 'EUR', 1000.00, '2015-01-01');
        $this->transactions[] = new Transaction($privateCustomer4,'withdraw', 'EUR', 1000.00, '2016-01-05');
        $this->transactions[] = new Transaction($privateCustomer,'deposit', 'EUR', 200.00, '2016-01-05');
        $this->transactions[] = new Transaction($businessCustomer,'withdraw', 'EUR', 300.00, '2016-01-15');
        $this->transactions[] = new Transaction($privateCustomer,'withdraw', 'JPY', 30000.00, '2016-01-06');
        $this->transactions[] = new Transaction($privateCustomer,'withdraw', 'USD', 100.00, '2016-01-07');
    }
}