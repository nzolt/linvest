<?php

namespace Tests\Unit;

use App\Exceptions\InvalidNameException;
use App\Helper\DateHelper;
use PHPUnit\Framework\TestCase;
use App\Data\Validators;

/**
 * @package Tests
 * @group unit
 * @group ready
 */
class HelpersTest extends TestCase
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
    public function testDateHelper()
    {
        $this->assertEquals(31, DateHelper::days_in_month(10, 2020));
        $this->assertNotEquals(28, DateHelper::days_in_month(2, 2020));
    }
}
