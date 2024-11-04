<?php

declare(strict_types=1);

namespace App\Api\EventListener\Http;

use App\Util\Domain\Exception\NotFoundException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Validator\Exception\ValidationFailedException;

final class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof UnprocessableEntityHttpException) {
            $validationFailed = $exception->getPrevious();

            if (!($validationFailed instanceof ValidationFailedException)) {
                $event->setResponse(self::createErrorResponse(
                    status: Response::HTTP_UNPROCESSABLE_ENTITY,
                    message: $exception->getMessage(),
                ));

                return;
            }

            $violations = $validationFailed->getViolations();
            $errors = [];
            foreach ($violations as $violation) {
                $errors[$violation->getPropertyPath()] = $violation->getMessage();
            }

            $event->setResponse(self::createErrorResponse(
                status: Response::HTTP_UNPROCESSABLE_ENTITY,
                errors: $errors,
                message: 'Invalid request data.',
            ));

            return;
        }

        if ($exception instanceof \InvalidArgumentException) {
            $event->setResponse(self::createErrorResponse(
                status: Response::HTTP_BAD_REQUEST,
                message: $exception->getMessage()
            ));


            return;
        }

        if ($exception instanceof \DomainException) {
            $event->setResponse(self::createErrorResponse(
                status: Response::HTTP_BAD_REQUEST,
                message: $exception->getMessage()
            ));


            return;
        }

        if ($exception instanceof NotFoundException) {
            $event->setResponse(self::createErrorResponse(
                status: Response::HTTP_NOT_FOUND,
                message: $exception->getMessage()
            ));


            return;
        }

        $event->setResponse(self::createErrorResponse(
            status: Response::HTTP_INTERNAL_SERVER_ERROR,
            message: 'Возникла неожиданная ошибка. Пожайлуста, повторите запрос позднее.'
        ));
    }

    private static function createErrorResponse(int $status, array $errors = [], ?string $message = null): JsonResponse
    {
        return new JsonResponse(
            data: [
                'errors' => $errors,
                'message' => $message
            ],
            status: $status
        );
    }
}
