<?php

namespace Interview\CommissionTask\Service\models;

class Customer
{
    private int $id;
    private string $accountType;

    /**
     * @param $id
     * @param $name
     * @param $phone
     * @param $accountType
     */

    public function __construct(int $id, string $accountType)
    {
        $this->id = $id;
        $this->accountType = $accountType;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    public function getAccountType(): string
    {
        return $this->accountType;
    }

    public function setAccountType(string $accountType)
    {
        $this->accountType = $accountType;
    }

}