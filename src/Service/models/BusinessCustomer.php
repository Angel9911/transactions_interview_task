<?php

namespace Interview\CommissionTask\Service\models;

class BusinessCustomer extends Customer
{
     private $type = 'business';

    public function __construct(string $id)
    {
        parent::__construct($id, $this->type);
    }


}