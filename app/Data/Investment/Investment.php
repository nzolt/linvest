<?php

namespace App\Data\Investment;

use App\Data\Validators\AmountValidator;
use App\Data\Validators\NameValidator;
use App\Exceptions\InvalidAmountException;
use App\Exceptions\InvalidNameException;
use DateTime;

class Investment
{
    /**
     * @var string
     */
    protected $investor = '';

    /**
     * @var \DateTime
     */
    protected $investmentDate = null;

    /**
     * @var int
     */
    protected $amount = 0.0;

    /**
     * @param string $investor
     * @param float $amount
     * @param DateTime|null $date
     * @throws InvalidAmountException
     * @throws InvalidNameException
     */
    public function __construct(string $investor, float $amount, DateTime $date = null)
    {
        if(!$date){
            $dtz = new DateTimeZone('UTC');
            $date = date_create("now", $dtz);
        }

        $this->setInvestmentDate($date);
        $this->setInvestor($investor);
        $this->setAmount($amount);

    }

    /**
     * @return string
     */
    public function getInvestor(): string
    {
        return $this->investor;
    }

    /**
     * @param string $investor
     */
    public function setInvestor(string $investor): void
    {
        if(NameValidator::validateName($investor)){
            $this->investor = $investor;
        } else {
            throw new InvalidNameException();
        }
    }

    /**
     * @return DateTime
     */
    public function getInvestmentDate(): ?DateTime
    {
        return $this->investmentDate;
    }

    /**
     * @param DateTime $investmentDate
     */
    public function setInvestmentDate(?DateTime $investmentDate): void
    {
        $this->investmentDate = $investmentDate;
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
        if(AmountValidator::ValidateAmount($amount)){
            $this->amount = $amount;
        } else {
            throw new InvalidAmountException();
        }
    }

}