<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Data\Wallet\VirtualWallet;

/**
 * @package Tests
 * @group unit
 * @group ready
 */
class VirtualWalletTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testVirtualValet()
    {
        $valet = new VirtualWallet('TestInvestor', 456);
        $this->assertEquals(456, $valet->getAmount());
        $this->assertSame('TestInvestor', $valet->getInvestor());
        $valet->addAmount(10.23);
        $this->assertEquals(466.23, $valet->getAmount());
    }
}
