<?php

namespace Interview\CommissionTask\Service\models;

class PrivateCustomer extends Customer
{
    private $type = 'private';

    public function __construct(string $id)
    {
        parent::__construct($id, $this->type);
    }


}