<?php

declare(strict_types=1);

namespace App\Api\Controller\V1\Credit\CheckClientEligibilty;

use App\CreditProcessing\Application\Credit\CheckClientEligibility\CheckClientEligibilityCommand;
use App\CreditProcessing\Application\Credit\CheckClientEligibility\CheckClientEligibilityHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CheckClientEligibilityAction
{
    public function __construct(private readonly CheckClientEligibilityHandler $eligibilityHandler)
    {
    }

    #[Route(path: '/clients/{clientId}/credit-eligibility', name: 'check_credit_eligibility', methods: ['GET'])]
    public function __invoke(
        string $clientId,
    ): JsonResponse {

        $isEligible = $this->eligibilityHandler->handle(new CheckClientEligibilityCommand($clientId));

        return new JsonResponse(data: [
            'eligible' => $isEligible,
        ], status: Response::HTTP_OK);
    }
}
