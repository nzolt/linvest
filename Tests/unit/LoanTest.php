<?php
    namespace Tests\Unit;

    use \PHPUnit\Framework\TestCase;
    use App\Data\Tranches\Tranch;
    use App\Data\Loan\Loan;
    use App\Data\Wallet\VirtualWalletFactory;

	/**
	 * Class LoanTest
	 * @package Tests
	 * @group unit
     * @group ready
	 */
    class LoanTest extends TestCase
    {
        public static function setUpBeforeClass(): void
        {
        }

        public function setUp(): void
        {
        }

        public function testInstance()
		{
            $trA = new Tranch('A', 1000, 3.2);
            $trB = new Tranch('B', 1000, 6.1);
            $loan = new Loan('2020-10-01', '2020-11-15', [$trA->getTranchId() => $trA, $trB->getTranchId() => $trB]);
			$this->assertInstanceOf('App\Data\Loan\Loan', $loan, 'Returned class is NOT RetrieveService instance');
		}

        public function testTranches()
        {
            $trA = new Tranch('A', 1000, 3.2);
            $trB = new Tranch('B', 1000, 6.1);
            $loan = new Loan('2020-10-01', '2020-11-15', [$trA->getTranchId() => $trA, $trB->getTranchId() => $trB]);
            $this->assertEquals(2, count($loan->getTranches()));

            $trC = new Tranch('C', 1000, 2.6);
            $loan->addTranch($trC->getTranchId(), $trC);
            $this->assertEquals(3, count($loan->getTranches()));
        }

        public function testInterest()
        {
            $vW1 = VirtualWalletFactory::createVirtualValet('InvestorOne', 1000);
            $vW3 = VirtualWalletFactory::createVirtualValet('InvestorTree', 1000);
            $trA = new Tranch('A', 1000, 3.2);
            $trB = new Tranch('B', 1000, 6.1);

            $loan = new Loan('2020-10-01', '2020-11-15', [$trA->getTranchId() => $trA, $trB->getTranchId() => $trB]);
            $loan->invest('A', $vW1, 1000, '2020-10-03');
            $loan->invest('B', $vW3, 500, '2020-10-10');
            $res = $loan->getInterests('2020-10-31');

            $this->assertEquals(28.9, $res[$vW1->getInvestor()]->getAmount());
            $this->assertEquals(20.66, $res[$vW3->getInvestor()]->getAmount());
        }

        public function testInterestInvestedFullException()
        {
            $vW1 = VirtualWalletFactory::createVirtualValet('InvestorOne', 1000);
            $vW2 = VirtualWalletFactory::createVirtualValet('InvestorTwo', 1000);
            $trA = new Tranch('A', 1000, 3.2);
            $trB = new Tranch('B', 1000, 6.1);

            $loan = new Loan('2020-10-01', '2020-11-15', [$trA->getTranchId() => $trA, $trB->getTranchId() => $trB]);
            $loan->invest('A', $vW1, 1000, '2020-10-03');

            $this->expectException('App\Exceptions\InvalidInvestException');
            $loan->invest('A', $vW2, 1, '2020-10-03');
        }

        public function testInterestOverAmountException()
        {
            $vW4 = VirtualWalletFactory::createVirtualValet('InvestorFour', 1000);
            $trA = new Tranch('A', 1000, 3.2);
            $trB = new Tranch('B', 1000, 6.1);

            $loan = new Loan('2020-10-01', '2020-11-15', [$trA->getTranchId() => $trA, $trB->getTranchId() => $trB]);

            $this->expectException('App\Exceptions\InvalidAmountException');
            $loan->invest('A', $vW4, 1100, '2020-10-03');
        }

        public function testInvestmentEnded()
        {
            $vW4 = VirtualWalletFactory::createVirtualValet('InvestorFour', 1000);
            $trA = new Tranch('A', 1000, 3.2);
            $trB = new Tranch('B', 1000, 6.1);
            $loan = new Loan('2020-10-01', '2020-11-15', [$trA->getTranchId() => $trA, $trB->getTranchId() => $trB]);

            $this->assertFalse($loan->invest('A', $vW4, 100, '2020-11-23'));
        }
    }