<?php

namespace Interview\CommissionTask\Service\validators;

/**
 * Validation class. Various system validations can be added here
 */
class Validation
{
    private static string $dateFormat = 'Y-m-d';

    public static function validateAsDate($date): bool
    {
        $isDateValid = \DateTime::createFromFormat(self::$dateFormat, $date);

        return $isDateValid && $isDateValid->format(self::$dateFormat) === $date;
    }

    public static function validateAsCurrency($currency): bool
    {
        return in_array($currency,TransactionOperationConstraints::paymentCurrencies);
    }

    public static function validateAsOperationType($operationType): bool
    {
        return in_array($operationType,TransactionOperationConstraints::paymentOperations);
    }

    public static function validateAsAccountType($accountType): bool
    {
        return in_array($accountType,$GLOBALS['config']['account_types']);
    }
}