<?php

declare(strict_types=1);

namespace App\CreditProcessing\Domain\Credit;

use App\CreditProcessing\Domain\Client\Client;
use App\CreditProcessing\Domain\Client\SSN;
use App\CreditProcessing\Domain\Credit\Product\Product;
use App\Util\Domain\Model\AggregateRoot;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
#[ORM\Table(name: 'credits')]
class CreditApplication extends AggregateRoot
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    private Uuid $id;

    #[ORM\Column(type: 'ssn')]
    private SSN $clientId;

    #[ORM\Column(type: 'string')]
    private string $productName;

    #[ORM\Column(type: 'integer')]
    private int $term;

    #[ORM\Column(type: 'float')]
    private float $interestRate;

    #[ORM\Column(type: 'float')]
    private float $amount;


    private function __construct(
        SSN    $clientId,
        string $product,
        int    $term,
        float  $interestRate,
        float  $amount,
    )
    {
        $this->id = Uuid::v4();
        $this->clientId = $clientId;
        $this->productName = $product;
        $this->term = $term;
        $this->interestRate = $interestRate;
        $this->amount = $amount;
    }


    public static function issue(
        Client             $client,
        Product            $product,
        int                $term,
        float              $amount,
        EligibilityChecker $eligibilityChecker
    ): self
    {

        if (!$eligibilityChecker->checkIsEligible($client)) {
            throw new \DomainException('Credit application denied');
        }

        $interestRate = $product->calculateInterestRate($client);

        $credit = new self($client->getId(), $product->getName(), $term, $interestRate, $amount);

        $credit->recordEvent(new CreditIssued(
            creditId: (string)$credit->getId(),
            clientName: $client->getName()->getFullName(),
            clientPhone: $client->getPhoneNumber()->getValue(),
            clientEmail: $client->getEmail()->getValue(),
            creditAmount: $credit->getAmount()
        ));

        return $credit;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getProductName(): string
    {
        return $this->productName;
    }

    public function getTerm(): int
    {
        return $this->term;
    }

    public function getInterestRate(): float
    {
        return $this->interestRate;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getClientId(): SSN
    {
        return $this->clientId;
    }
}
