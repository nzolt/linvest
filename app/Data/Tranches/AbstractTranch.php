<?php

namespace App\Data\Tranches;

abstract class AbstractTranch
{
    /**
     * @var string
     */
    protected $tranchId = '';

    /**
     * @var float
     */
    protected $interest = 0.0;

    /**
     * @var int
     */
    protected $maxAmount = 0;

    /**
     * @var int
     */
    protected $availableAmount = 0;

    /**
     * @return string
     */
    public function getTranchId(): string
    {
        return $this->tranchId;
    }

    /**
     * @param string $tranchId
     */
    public function setTranchId(string $tranchId): void
    {
        $this->tranchId = $tranchId;
    }

    /**
     * @return float
     */
    public function getInterest(): float
    {
        return $this->interest;
    }

    /**
     * @param float $interest
     */
    public function setInterest(float $interest): void
    {
        $this->interest = $interest;
    }

    /**
     * @return int
     */
    public function getMaxAmount(): int
    {
        return $this->maxAmount;
    }

    /**
     * @param int $maxAmount
     */
    public function setMaxAmount(int $maxAmount): void
    {
        $this->maxAmount = $maxAmount;
    }

    /**
     * @return int
     */
    public function getAvailableAmount(): int
    {
        return $this->availableAmount;
    }

    /**
     * @param int $availableAmount
     */
    public function setAvailableAmount(int $availableAmount): void
    {
        $this->availableAmount = $availableAmount;
    }

}