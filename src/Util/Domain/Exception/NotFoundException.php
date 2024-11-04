<?php

declare(strict_types=1);

namespace App\Util\Domain\Exception;

use Psr\Container\NotFoundExceptionInterface;

final class NotFoundException extends \LogicException implements NotFoundExceptionInterface
{
}
