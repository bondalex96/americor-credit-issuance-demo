<?php

declare(strict_types=1);

namespace App\CreditProcessing\Domain\Client;

use App\Util\Domain\Validation\Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class FICOScore
{
    #[ORM\Column(type: 'integer')]
    private readonly int $score;

    public function __construct(int $score)
    {
        $this->validate($score);
        $this->score = $score;
    }

    private function validate(int $score): void
    {
        Assert::range($score, 300, 850, 'FICO score must be between 300 and 850');
    }

    public function getScore(): int
    {
        return $this->score;
    }
}
