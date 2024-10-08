<?php

namespace Interview\CommissionTask\Service\validators;

/**
 * Class handling with the transaction constraints of the system.
 * It will be easier to edit from here instead of editing every place where constraints are used.
 */
final class TransactionOperationConstraints
{
     const withdrawBusinessCommissionFee = 0.005; //0.5% for business clients
     const withdrawPrivateCommissionFee = 0.003; // 0.3% for private clients
     const depositCommissionFee = 0.0003; // 0.03% for deposit
     const paymentCurrencies = ['EUR', 'USD', 'JPY'];

     const paymentOperations = ['deposit', 'withdraw'];
}