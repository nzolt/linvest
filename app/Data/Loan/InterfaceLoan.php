<?php

namespace App\Data\Loan;

use App\Data\Tranches\Tranch;

interface InterfaceLoan
{
    /**
     * @return mixed
     */
    public function getStartDate();

    /**
     * @param \DateTime $startDate
     */
    public function setStartDate(\DateTime $startDate): void;

    /**
     * @return mixed
     */
    public function getEndDate();

    /**
     * @param \DateTime $endDate
     */
    public function setEndDate(\DateTime $endDate): void;

    /**
     * @return array
     */
    public function getTranches(): array;

    /**
     * @param array $tranches
     */
    public function setTranches(array $tranches): void;

    /**
     * @param string $tranchId
     * @param Tranch $tranch
     */
    public function addTranch(string $tranchId, Tranch $tranch): void;

    /**
     * @param string $tranchId
     * @return Tranch
     */
    public function getTranch(string $tranchId): Tranch;
}