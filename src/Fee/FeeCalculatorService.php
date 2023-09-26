<?php

declare(strict_types=1);

namespace App\Fee;

use App\Fee\FeeCalculator;
use App\Model\LoanProposal;

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
        $reminder = fmod($total, 5.0);
        $fee = (float) $reminder > 0.0 ? (float) $fee + (5.0 - (float) $reminder) : (float) $fee;
        return round($fee, 2);
    }
}
