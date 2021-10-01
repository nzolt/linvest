<?php

namespace App\Data\Loan;
use App\Data\Investment\Investment;
use App\Data\Loan\AbstractLoan;
use App\Data\Loan\InterfaceLoan;
use App\Data\Tranches\Tranch;
use App\Data\Wallet\VirtualWallet;
use App\Data\Wallet\VirtualWalletFactory;
use App\Exceptions\InvalidTranchException;
use App\Helper\DateHelper;
use phpDocumentor\Reflection\Types\Boolean;

class Loan extends AbstractLoan implements InterfaceLoan
{
    /**
     * @var \DateTimeZone $dtz
     */
    protected $dtz;

    /**
     * @param string $startDate
     * @param string $endDate
     * @param array $tranches
     */
    public function __construct(string $startDate, string $endDate, array $tranches = [])
    {
        $this->dtz = new \DateTimeZone('UTC');
        $this->setStartDate(date_create($startDate, $this->dtz));
        $this->setEndDate(date_create($endDate, $this->dtz));
        if(count($tranches) > 0){
            foreach ($tranches as $tranchId => $tranch){
                $this->addTranch($tranchId, $tranch);
            }
        }
    }

    /**
     * @param \DateTime $startDate
     */
    public function setStartDate(\DateTime $startDate): void
    {
        parent::setStartDate($startDate);
    }

    /**
     * @param \DateTime $startDate
     */
    public function setEndDate(\DateTime $startDate): void
    {
        parent::setEndDate($startDate);
    }

    /**
     * @param string $tranchId
     * @return Tranch
     * @throws InvalidTrancheException
     */
    public function getTranch(string $tranchId): Tranch
    {
        if(array_key_exists($tranchId, $this->tranches)){
            return $this->tranches[$tranchId];
        } else {
            throw new InvalidTranchException();
        }
    }

    /**
     * @param string $tranchId
     * @param VirtualWallet $virtualWallet
     * @param int $amount
     * @param string $investDate
     * @param string $dateFormat
     * @return bool
     * @throws \App\Exceptions\InvalidAmountException
     * @throws \App\Exceptions\InvalidInvestException
     */
    public function invest(
        string $tranchId,
        VirtualWallet $virtualWallet,
        int $amount,
        string $investDate = ''): bool
    {
        $tranch = $this->getTranch($tranchId);
        if($investDate != ''){
            $date = date_create($investDate, $this->dtz);
        } else {
            $date = date_create("now", $this->dtz);
        }

        if($this->getEndDate()->getTimestamp() >= $date->getTimestamp()){
            return $tranch->invest($virtualWallet, $amount, $date);
        }

        return false;
    }

    /**
     * @return array
     */
    public function getInterests(string $toDate = ''): array
    {
        $valets = [];
        $tranchEndDate = date_create('now', $this->dtz);
        if($toDate != ''){
            $tranchEndDate = date_create($toDate, $this->dtz);
        }
        $days = DateHelper::days_in_month($tranchEndDate->format('m'), $tranchEndDate->format('Y'));
        foreach ($this->getTranches() as $tranch){
            foreach ($tranch->getInvestments() as $investment){
                $interest = $this->calculateInterest($tranch, $investment, $tranchEndDate, $days);
                if(array_key_exists($investment->getInvestor(), $valets)){
                    $valet = $valets[$investment->getInvestor()];
                } else {
                    $valet = VirtualWalletFactory::createVirtualValet($investment->getInvestor());
                }
                $valet->addAmount($interest);
                $valets[$investment->getInvestor()] = $valet;
            }
        }
        return $valets;
    }

    protected function calculateInterest(Tranch $tranch, Investment $investment, \DateTime $tranchEndDate, int $days): float
    {
        $loanStartDate = $investment->getInvestmentDate();
        $loanDays = date_diff($loanStartDate, $tranchEndDate);
        // Solution based on docs
        //Daily interest rate = Interest rate / Days in a month
        $dir = $tranch->getInterest() / $days;
        //Invested period interest rate = Daily interest rate * Days invested
        $ipir = $dir * $loanDays->days;
        //Earned interest = Invested amount / 100 * Invested period interest rate (1)
        $intP = $investment->getAmount() / 100 * $ipir;
        return round($intP, 2);

        // My solution. Seems to produce same result
        /*$intP = $investment->getAmount() * $tranch->getInterest();var_dump($intP);
        $ipd = $intP / $tranchDays->days;var_dump($ipd);
        return round($ipd * $loanDays->days, 2);*/
    }
}