<?php

namespace Interview\CommissionTask\Service\models;

class PrivateCustomer extends Customer
{
    private string $type = 'private';

    public function __construct(int $id)
    {
        parent::__construct($id, $this->type);
    }


}