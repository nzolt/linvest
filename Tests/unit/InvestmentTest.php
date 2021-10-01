<?php
    namespace Tests\Unit;

    use App\Data\Investment\Investment;
    use App\Exceptions\InvalidAmountException;
    use App\Exceptions\InvalidNameException;
    use \PHPUnit\Framework\TestCase;

	/**
	 * Class TranchTest
	 * @package Tests
	 * @group unit
     * @group ready
	 */
    class InvestmentTest extends TestCase
    {
        /**
         * @var $tranch Tranch
         */
        protected $investment;
        /**
         * @var $dtz \DateTimeZone
         */
        protected $dtz;

        public static function setUpBeforeClass(): void
        {
        }

        public function setUp(): void
        {
            $this->dtz = new \DateTimeZone('UTC');
            $this->investment = new Investment('A', 100, date_create("now", $this->dtz));
        }

        public function testInstance()
		{
            $this->dtz = new \DateTimeZone('UTC');
            $this->investment = new Investment('A', 100, date_create("now", $this->dtz));
			$this->assertInstanceOf('App\Data\Investment\Investment', $this->investment, 'Returned class is NOT a Tranch instance');
		}

        public function testInvestment()
        {
            $iA = new Investment('X', 1200, date_create('2020-05-21', $this->dtz));
            $this->assertSame('X', $iA->getInvestor());
            $this->assertEquals(1200, $iA->getAmount());
            $this->assertInstanceOf('\DateTime', $iA->getInvestmentDate());
            $this->assertEquals('21', $iA->getInvestmentDate()->format('d'));
        }

        public function testInvestmentNameExceptions()
        {
            $this->expectException(InvalidNameException::class);
            $iA = new Investment('X $', 1200, date_create('2020-05-21', $this->dtz));
        }

        public function testInvestmentAmountExceptions()
        {
            $this->expectException(InvalidAmountException::class);
            $ia = new Investment('X', -1, date_create('2020-05-21', $this->dtz));
        }

        public function testInvestmentSetNameExceptions()
        {
            $this->expectException(InvalidNameException::class);
            $this->investment->setInvestor('@ v');
        }

        public function testInvestmentSetAmountExceptions()
        {
            $this->expectException(InvalidAmountException::class);
            $this->investment->setAmount(-1);
        }
    }