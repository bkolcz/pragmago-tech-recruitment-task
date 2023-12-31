<?php

declare(strict_types=1);

namespace App\Fee;

use App\Model\LoanProposal;

interface FeeCalculator
{
    /**
     * @return float The calculated total fee.
     */
    public function calculate(LoanProposal $application): float;
}
