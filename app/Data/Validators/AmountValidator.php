<?php


namespace App\Data\Validators;


use App\Exceptions\InvalidAmountException;

/**
 * Class NameValidator
 * @package App\Data
 */
class AmountValidator
{
    /**
     * @param $amount
     * @return bool
     */
    public static function validateAmount($amount, $min = 1): bool
    {
        return filter_var($amount, FILTER_CALLBACK,
            array('options' => self::isValid($amount, $min)));
    }

    public static function isValid($amount, $min)
    {
        return function($value = null) use ($amount, $min) {
            $a = filter_var($amount, FILTER_VALIDATE_FLOAT,
                array('options' => ['min' => $min]));
            if (($amount >= $min) && $a) return true;
            return false;
        };
    }
}
