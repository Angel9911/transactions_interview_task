<?php

namespace Interview\CommissionTask\Service\models;

class BusinessCustomer extends Customer
{
     private string $type = 'business';

    public function __construct(int $id)
    {
        parent::__construct($id, $this->type);
    }


}