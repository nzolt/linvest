<?php

namespace App\Data\Tranches;

use App\Data\Investment\Investment;
use App\Data\Validators\AmountValidator;
use App\Data\Wallet\VirtualWallet;
use App\Exceptions\InvalidAmountException;
use App\Exceptions\InvalidInterestException;
use App\Exceptions\InvalidInvestException;

class Tranch extends AbstractTranch
{

    /**
     * @var array
     */
    protected $investments = [];

    /**
     * @var int
     */
    protected $totalInvestment = 0;

    public function __construct(string $tranchId, int $amount, float $interest)
    {
        $this->setTranchId($tranchId);
        $this->setMaxAmount($amount);
        $this->setInterest($interest);
    }

    /**
     * @param int $maxAmount
     */
    public function setMaxAmount(int $maxAmount): void
    {
        if(AmountValidator::validateAmount($maxAmount)){
            parent::setMaxAmount($maxAmount);
            if($this->getAvailableAmount() == 0){
                $this->setAvailableAmount($maxAmount);
            }
        }
    }

    /**
     * @param float $interest
     */
    public function setInterest(float $interest): void
    {
        if(AmountValidator::validateAmount($interest, 0.1)) {
            $this->interest = $interest;
        } else {
            throw new InvalidInterestException();
        }
    }

    /**
     * @return array
     */
    public function getInvestments(): array
    {
        return $this->investments;
    }

    /**
     * @param VirtualWallet $virtualWallet
     * @param int $amount
     * @return bool
     * @throws InvalidAmountException
     * @throws InvalidInvestException
     */
    public function invest(VirtualWallet $virtualWallet, int $amount, \DateTime $investmentDate): bool
    {
        if($virtualWallet->checkInvestAmount($amount)){
            if($this->getAvailableAmount() >= $virtualWallet->getInvestAmount($amount)){
                $this->addInvestment($virtualWallet->getInvestor(), $amount, $investmentDate);
                return true;
            } else {
                throw new InvalidInvestException();
            }
        } else {
            throw new InvalidAmountException();
        }

        return false;
    }

    /**
     * @return int
     */
    public function getTotalInvestment(): int
    {
        return $this->totalInvestment;
    }

    /**
     * @return void
     */
    public function setTotalInvestment($amount): void
    {
        $this->totalInvestment += $amount;
    }

    /**
     * @param string $investor
     * @param int $investment
     */
    public function addInvestment(string $investor, int $investment, \DateTime $investmentDate): void
    {
        $this->investments[] = new Investment($investor, $investment, $investmentDate); // Keep track of investors and their investments
        $this->setTotalInvestment($investment);
        $this->setAvailableAmount($this->getMaxAmount() - $this->getTotalInvestment());
    }
}