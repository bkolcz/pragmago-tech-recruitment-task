<?php

declare(strict_types=1);

namespace App\Fee;

use PragmaGoTech\Interview\Fee\FeeCalculator;
use PragmaGoTech\Interview\Model\LoanProposal;

class FeeCalculatorService implements FeeCalculator
{

    public function calculate(LoanProposal $application): float
    {
        return match ($application->term()) {
            12 => $this->oneYearLoan($application->amount()),
            24 => $this->twoYearLoan($application->amount()),
            default => -1.0
        };
    }

    private function oneYearLoan(float $amount): float
    {
        return match (true) {
            1000 <= $amount && 2000 > $amount => $this->normalizeFee($amount, 0.05),
            2000 <= $amount && 3000 > $amount => $this->normalizeFee($amount, 0.045),
            3000 <= $amount && 4000 > $amount => $this->normalizeFee($amount, 0.03),
            4000 <= $amount && 5000 > $amount => $this->normalizeFee($amount, 0.02875),
            5000 <= $amount && 20000 >= $amount => $this->normalizeFee($amount, 0.02),
            default => -1.0
        };
    }
    private function twoYearLoan(float $amount): float
    {
        return match (true) {
            1000 <= $amount && 2000 > $amount => $this->normalizeFee($amount, 0.07),
            2000 <= $amount && 3000 > $amount => $this->normalizeFee($amount, 0.05),
            2000 <= $amount && 20000 >= $amount => $this->normalizeFee($amount, 0.04),
            default => -1.0
        };
    }

    private function normalizeFee(float $amount, float $interestRate): float
    {
        $fee = (float) $amount * (float) $interestRate;
        $total = (float) $amount + (float) $fee;
        $reminder = (float) $total % 5.0;
        return round($fee + $reminder, 2);
    }
}
