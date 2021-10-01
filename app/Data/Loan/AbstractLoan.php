<?php

namespace App\Data\Loan;

use App\Data\Tranches\Tranch;
use DateTime;

abstract class AbstractLoan
{

    protected $startDate;
    protected $endDate;
    protected $tranches = [];

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param \DateTime $startDate
     */
    public function setStartDate(\DateTime $startDate): void
    {
        $this->startDate = $startDate;
        $this->startDate->setTimezone($this->dtz);
    }

    /**
     * @return mixed
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param DateTime $endDate
     */
    public function setEndDate(\DateTime $endDate): void
    {
        $this->endDate = $endDate;
    }

    /**
     * @return array
     */
    public function getTranches(): array
    {
        return $this->tranches;
    }

    /**
     * @param array $tranches
     */
    public function setTranches(array $tranches): void
    {
        $this->tranches = $tranches;
    }

    /**
     * @param string $tranchId
     * @param Tranch $tranch
     */
    public function addTranch(string $tranchId, Tranch $tranch): void
    {
        $this->tranches[$tranchId] = $tranch;
    }

}