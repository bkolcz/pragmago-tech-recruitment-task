<?php

namespace App\Tests;

use App\Fee\FeeCalculatorService;
use PHPUnit\Framework\TestCase;
use App\Model\LoanProposal;

class FeeCalculatorServiceTest extends TestCase
{
    /**
     * @dataProvider oneYearProvider
     */
    public function testOneYear(float $amount, float $fee): void
    {
        $calculator = new FeeCalculatorService();
        $proposal = new LoanProposal(12, (float) $amount);
        $this->assertEquals((float) $fee, $calculator->calculate($proposal));
    }

    /**
     * @dataProvider twoYearProvider
     */
    public function testTwoYear(float $amount, float $fee): void
    {
        $calculator = new FeeCalculatorService();
        $proposal = new LoanProposal(24, (float)$amount);
        $this->assertEquals((float) $fee, $calculator->calculate($proposal));
    }

    public function oneYearProvider()
    {
        return array(
            array(1000, 50),
            array(2000, 90),
            array(3000, 90),
            array(4000, 115),
            array(5000, 100),
            array(6000, 120),
            array(7000, 140),
            array(8000, 160),
            array(9000, 180),
            array(10000, 200),
            array(11000, 220),
            array(12000, 240),
            array(13000, 260),
            array(14000, 280),
            array(15000, 300),
            array(16000, 320),
            array(17000, 340),
            array(18000, 360),
            array(19000, 380),
            array(20000, 400),
            array(1021, 54),
            array(2021, 94),
            array(900, -1),
            array(20020, -1),
        );
    }

    /**
     * Summary of twoYearProvider
     * @return array
     */
    public function twoYearProvider()
    {
        return array(
            array(1000, 70),
            array(2000, 100),
            array(3000, 120),
            array(4000, 160),
            array(5000, 200),
            array(6000, 240),
            array(7000, 280),
            array(8000, 320),
            array(9000, 360),
            array(10000, 400),
            array(11000, 440),
            array(12000, 480),
            array(13000, 520),
            array(14000, 560),
            array(15000, 600),
            array(16000, 640),
            array(17000, 680),
            array(18000, 720),
            array(19000, 760),
            array(20000, 800),
            array(1021, 74),
            array(2021, 104),
            array(900, -1),
            array(20020, -1),
        );
    }
}
