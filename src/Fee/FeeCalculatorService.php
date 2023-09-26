<?php

declare(strict_types=1);

use PragmaGoTech\Interview\Fee\FeeCalculator;
use PragmaGoTech\Interview\Model\LoanProposal;

class FeeCalculatorService implements FeeCalculator
{

    public function calculate(LoanProposal $application): float
    {
        return match($application) {
            12 === $application->term() => $this->oneYearLoan($application->amount()),
            24 === $application->term() => $this->twoYearLoan($application->amount()),
            default => -1.0
        };
    }

    private function oneYearLoan(float $amount): float {
        return match($amount) {
            1000 <= $amount && 2000 < $amount => $this->normalizeFee($amount,0.05),
            2000 <= $amount && 3000 < $amount => $this->normalizeFee($amount,0.045),
            3000 <= $amount && 4000 < $amount => $this->normalizeFee($amount,0.03),
            4000 <= $amount && 20000 < $amount => $this->normalizeFee($amount,0.02875),
            default => -1.0
        };
    }
    private function twoYearLoan(float $amount): float {
        return match($amount) {
            1000 <= $amount && 2000 < $amount => $this->normalizeFee($amount,0.05),
            2000 <= $amount && 20000 < $amount => $this->normalizeFee($amount,0.04),
            default => -1.0
        };
    }

    private function normalizeFee(float $amount, float $interestRate): float {
        return 0.0; // TODO
    }
}
