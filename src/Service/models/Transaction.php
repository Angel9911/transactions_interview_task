<?php

namespace Interview\CommissionTask\Service\models;

class Transaction
{
    private $customer;
    private $operation;
    private $currency;
    private $amount;
    private $date;

    public function __construct(Customer $customer, $operation, $currency, $amount, $date)
    {
        $this->customer = $customer;
        $this->operation = $operation;
        $this->currency = $currency;
        $this->amount = $amount;
        $this->date = $date;
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function setCustomer(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function getOperation(): string{
        return $this->operation;
    }

    public function setOperation(string $operation){
        $this->operation = $operation;
    }

    /**
     * @return mixed
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param mixed $currency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    public function getDate(){
        return $this->date;
    }

    public function setDate($date){
        $this->date = $date;
    }

}