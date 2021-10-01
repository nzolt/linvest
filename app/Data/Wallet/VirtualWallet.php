<?php

namespace App\Data\Wallet;

use App\Exceptions\InvalidAmountException;
use App\Data\Validators\AmountValidator;
use App\Data\Validators\NameValidator;
class VirtualWallet
{
    protected $investor = '';
    protected $amount = 0.0;

    /**
     * @return string
     */
    public function getInvestor(): string
    {
        return $this->investor;
    }

    /**
     * @param string $investor
     * @param float $amount
     * @return VirtualWallet
     */
    public function __construct(string $investor, float $amount = 0)
    {
        $this->setInvestor($investor);
        $this->setAmount($amount);
        return $this;
    }

    /**
     * @param string $investor
     */
    public function setInvestor(string $investor): void
    {
        if(NameValidator::validateName($investor)){
            $this->investor = $investor;
        }
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     */
    public function setAmount(float $amount): void
    {
        if(AmountValidator::validateAmount($amount)){
            $this->amount = $amount;
        }
    }

    /**
     * @param float $amount
     */
    public function addAmount(float $amount): void
    {
        if(AmountValidator::validateAmount($amount)){
            $this->amount += $amount;
        }

    }

    /**
     * @return float
     */
    public function checkInvestAmount(float $amount): bool
    {
        if($this->amount >= $amount && AmountValidator::validateAmount($amount)){
            return true;
        }
        return false;
    }

    /**
     * @param float $amount
     * @return bool
     * @throws InvalidAmountException
     */
    public function getInvestAmount(float $amount): bool
    {
        if($this->checkInvestAmount($amount)){
            $this->amount -= $amount;
            return $amount;
        } else {
            throw new InvalidAmountException();
        }
    }
}