<?php
    namespace Tests\Unit;

    use \PHPUnit\Framework\TestCase;
    use App\Data\Tranches\Tranch;

	/**
	 * Class TranchTest
	 * @package Tests
	 * @group unit
     * @group ready
	 */
    class TranchTest extends TestCase
    {
        /**
         * @var $tranch Tranch
         */
        protected $tranch;

        public static function setUpBeforeClass(): void
        {
        }

        public function setUp(): void
        {
            $this->tranch = new Tranch('A', 100, 1);
        }

        public function testInstance()
		{
			$this->assertInstanceOf('App\Data\Tranches\Tranch', $this->tranch, 'Returned class is NOT a Tranch instance');
		}

        public function testTranch()
        {
            $trA = new Tranch('X', 1200, 1.1);
            $this->assertSame('X', $trA->getTranchId());
            $this->assertEquals(1200, $trA->getMaxAmount());
            $trA->setMaxAmount(1000);
            $this->assertNotEquals(1200, $trA->getMaxAmount());
            $this->assertEquals(1000, $trA->getMaxAmount());
            $trA->setInterest(3.2);
            $this->assertEquals(3.2, $trA->getInterest());
        }

        public function testTranchExceptions()
        {
            $trA = new Tranch('X', 1200, 1.1);

            $this->expectException('App\Exceptions\InvalidInterestException');
            $trA->setInterest(-1);

            $this->expectException('App\Exceptions\InvalidInterestException');
            $trB = new Tranch('nT', 1000, -0.2);
        }
    }