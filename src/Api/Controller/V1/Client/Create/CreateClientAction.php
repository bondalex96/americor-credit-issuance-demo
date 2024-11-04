<?php

declare(strict_types=1);

namespace App\Api\Controller\V1\Client\Create;

use App\CreditProcessing\Application\Client\Create\CreateClientCommand;
use App\CreditProcessing\Application\Client\Create\CreateClientHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

final class CreateClientAction
{
    public function __construct(private readonly CreateClientHandler $handler)
    {
    }

    #[Route(path: '/clients', name: 'create_client', methods: ['POST'])]
    public function __invoke(
        #[MapRequestPayload] CreateClientRequest $request
    ): JsonResponse {

        $id = $this->handler->handle(
            new CreateClientCommand(
                lastName: $request->lastName,
                firstName: $request->firstName,
                age: $request->age,
                address: $request->address,
                ssn: $request->ssn,
                fico: $request->fico,
                email: $request->email,
                phoneNumber: $request->phoneNumber,
                monthlyIncome: $request->monthlyIncome,
            )
        );

        return new JsonResponse(data: ['id' => $id], status: Response::HTTP_CREATED);
    }
}
