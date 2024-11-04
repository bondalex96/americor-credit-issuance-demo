<?php

declare(strict_types=1);

namespace App\Util\Tests\Helper;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\KernelInterface;

trait DatabaseTrait
{
    protected function saveEntity(object $entity): void
    {
        static::getEntityManager()->persist($entity);
        static::getEntityManager()->flush();
        static::getEntityManager()->clear();
    }


    protected static function getEntityManager(): ?EntityManagerInterface
    {
        if (static::$kernel) {
            return static::$kernel
                ->getContainer()
                ->get('doctrine.orm.entity_manager')
                ;
        }

        return null;
    }
}
