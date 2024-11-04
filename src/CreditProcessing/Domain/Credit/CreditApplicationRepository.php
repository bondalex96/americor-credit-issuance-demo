<?php

declare(strict_types=1);

namespace App\CreditProcessing\Domain\Credit;

interface CreditApplicationRepository
{
    public function save(CreditApplication $credit): void;
}
