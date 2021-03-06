<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Data\Wallet\VirtualWalletFactory;

/**
 * @package Tests
 * @group unit
 * @group ready
 */
class VirtualWalletFactoryTest extends TestCase
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
    public function testFactory()
    {
        $valet = VirtualWalletFactory::createVirtualValet('TestInvestor', 456);
        $this->assertInstanceOf('App\Data\Wallet\VirtualWallet', $valet);
        $this->assertEquals(456, $valet->getAmount());
        $this->assertSame('TestInvestor', $valet->getInvestor());
    }
}
