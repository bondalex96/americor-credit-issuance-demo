<?php

declare(strict_types=1);

namespace App\Api\Controller\V1\Client\Update;

use App\CreditProcessing\Application\Client\Update\UpdateClientCommand;
use App\CreditProcessing\Application\Client\Update\UpdateClientHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

final class UpdateClientAction
{
    public function __construct(private readonly UpdateClientHandler $handler)
    {
    }

    #[Route(path: '/clients/{ssn}', name: 'update_client', methods: ['PATCH'])]
    public function __invoke(
        string $ssn,
        #[MapRequestPayload] UpdateClientRequest $request
    ): JsonResponse {
        $command = new UpdateClientCommand(
            ssn: $ssn,
            lastName: $request->lastName,
            firstName: $request->firstName,
            age: $request->age,
            address: $request->address,
            fico: $request->fico,
            email: $request->email,
            phoneNumber: $request->phoneNumber,
            monthlyIncome: $request->monthlyIncome,
        );

        $this->handler->handle($command);

        return new JsonResponse(status: Response::HTTP_NO_CONTENT);
    }
}
