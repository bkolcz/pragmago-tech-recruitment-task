<?php
declare(strict_types=1);

namespace App\Controller;

use App\Fee\FeeCalculator;
use App\Model\LoanProposal;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home', methods: ['GET'])]
    public function index(Request $request, FeeCalculator $feeCalculator): JsonResponse
    {
        $term = intval($request->query->get('term'));
        $amount = floatval($request->query->get('amount'));
        $fee = $feeCalculator->calculate(new LoanProposal($term,$amount));
        return $this->json([
            'term' => $term,
            'amount' => $amount,
            'fee' => $fee === -1.0 ? 'Such conditions are not supported' : $fee,
            'cost' => $fee === -1.0 ? '' : $amount + $fee,
        ]);
    }
}
