<?php

declare(strict_types=1);

namespace App\CreditProcessing\Tests\Domain\Client;

use App\CreditProcessing\Domain\Client\FICOScore;
use PHPUnit\Framework\TestCase;

final class FICOScoreTest extends TestCase
{
    public function testValidScore(): void
    {
        $ficoScore = new FICOScore(750);
        self::assertEquals(750, $ficoScore->getScore());
    }

    public function testBoundaryMinScore(): void
    {
        $ficoScore = new FICOScore(300);
        self::assertEquals(300, $ficoScore->getScore());
    }

    public function testBoundaryMaxScore(): void
    {
        $ficoScore = new FICOScore(850);
        self::assertEquals(850, $ficoScore->getScore());
    }

    public function testTooLowScore(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new FICOScore(250);
    }

    public function testTooHighScore(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new FICOScore(900);
    }
}
