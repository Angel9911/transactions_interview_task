<?php

namespace Interview\CommissionTask\Service\models;

class Transaction
{
    private Customer $customer;
    private string $operation;
    private string $currency;
    private float $amount;
    private string $date;

    public function __construct(Customer $customer, string $operation, string $currency, float $amount, string $date)
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