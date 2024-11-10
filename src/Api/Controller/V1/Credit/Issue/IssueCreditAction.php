<?php

declare(strict_types=1);

namespace App\Api\Controller\V1\Credit\Issue;

use App\CreditProcessing\Application\Credit\Issue\IssueCreditCommand;
use App\CreditProcessing\Application\Credit\Issue\IssueCreditHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

final class IssueCreditAction
{
    public function __construct(private readonly IssueCreditHandler $handler)
    {
    }

    #[Route(path: '/credits', name: 'issue_credit', methods: ['POST'])]
    public function __invoke(
        #[MapRequestPayload]IssueCreditRequest $request
    ): JsonResponse {
        $creditData = $this->handler->handle(
            new IssueCreditCommand(
                clientId: $request->clientId,
                product: $request->product,
                amount: $request->amount,
                term: $request->term
            )
        );
        return new JsonResponse([
            'creditId' => $creditData->id,
            'interestRate' => $creditData->interestRate,
            'amount' => $creditData->amount,
            'term' => $creditData->term
        ], Response::HTTP_CREATED);
    }
}
