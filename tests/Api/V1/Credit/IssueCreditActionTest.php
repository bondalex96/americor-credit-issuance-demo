<?php

declare(strict_types=1);

namespace Api\V1\Credit;

use App\CreditProcessing\Domain\Credit\CreditIssued;
use App\Util\Domain\EventDispatcher\EventDispatcher;
use App\Util\Domain\EventDispatcher\RecordInMemoryEventDispatcher;
use App\Util\Tests\Helper\DatabaseTrait;
use Helpers\ClientBuilder;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class IssueCreditActionTest extends WebTestCase
{
    use DatabaseTrait;

    private KernelBrowser $client;
    private ClientBuilder $clientBuilder;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->clientBuilder = (new ClientBuilder());
    }

    /**
     * @dataProvider productTypeProvider
     */
    public function testSuccessfulCreditIssuance(string $address, string $product, float $expectedInterestRate): void
    {
        $client = $this->clientBuilder
            ->withAge(30)
            ->withAddress($address)
            ->withFICOScore(650)
            ->withMonthlyIncome(2000)
            ->build();

        $this->saveEntity($client);

        $this->client->jsonRequest(
            method: 'POST',
            uri: '/v1/credits',
            parameters: [
                'clientId' => $client->getId()->getValue(),
                'product' => $product,
                'amount' => 5000,
                'term' => 24
            ]
        );

        $this->assertResponseStatusCodeSame(201);
        $response = json_decode(
            $this->client->getResponse()->getContent(),
            true
        );

        $this->assertArrayHasKey('creditId', $response);
        $this->assertSame(36, strlen($response['creditId']));

        $this->assertArrayHasKey('interestRate', $response);
        $this->assertEquals($expectedInterestRate, $response['interestRate']);

        $this->assertArrayHasKey('amount', $response);
        $this->assertSame(5000, $response['amount']);

        $this->assertArrayHasKey('term', $response);
        $this->assertSame(24, $response['term']);

        $events = $this->getEventDispatcher()->getTriggeredEvents();
        $this->assertCount(1, $events);
        $this->assertInstanceOf(CreditIssued::class, $events[0]);
        $this->assertSame($response['creditId'], $events[0]->creditId);
    }


    public function productTypeProvider(): array
    {
        return [
            ['Los Angeles, CA 90001', 'personal', 19.49],
            ['Los Angeles, CA 90001', 'student', 17.49],
            ['Los Angeles, CA 90001', 'debt_consolidation', 21.49],
            ['Las Vegas, NV 89109', 'personal', 8.0],
            ['Las Vegas, NV 89109', 'student', 6.0],
            ['Las Vegas, NV 89109', 'debt_consolidation', 10.0],
        ];
    }

    public function testCreditIssuanceWithNonexistentClient(): void
    {
        $this->client->jsonRequest(
            method: 'POST',
            uri: $this->getUrl(),
            parameters: [
                'clientId' => '123-45-6789',
                'product' => 'personal',
                'amount' => 5000,
                'term' => 24
            ]
        );

        $this->assertJsonStringEqualsJsonString(
            json_encode(
                [
                    'errors' => [],
                    'message' => 'Client with id 123-45-6789 not found'
                ]
            ),
            $this->client->getResponse()->getContent()
        );

        $this->assertResponseStatusCodeSame(404);
    }

    public function testCreditIssuanceIneligibleDueToYoungAge(): void
    {
        $client = $this->clientBuilder
            ->withAge(17) // Молодой клиент
            ->build();

        $this->saveEntity($client);

        $this->client->jsonRequest(
            method: 'POST',
            uri: '/v1/credits',
            parameters: [
                'clientId' => $client->getId()->getValue(),
                'product' => 'personal',
                'amount' => 5000,
                'term' => 24
            ]
        );

        $this->assertResponseStatusCodeSame(400);
        $this->assertJsonStringEqualsJsonString(
            json_encode(
                [
                    'errors' => [],
                    'message' => 'Credit application denied',
                ]
            ),
            $this->client->getResponse()->getContent()
        );
    }

    public function testCreditIssuanceIneligibleDueToLowIncome(): void
    {
        $client = $this->clientBuilder
            ->withMonthlyIncome(800)
            ->build();

        $this->saveEntity($client);

        $this->client->jsonRequest(
            method: 'POST',
            uri: '/v1/credits',
            parameters: [
                'clientId' => $client->getId()->getValue(),
                'product' => 'personal',
                'amount' => 5000,
                'term' => 24
            ]
        );

        $this->assertResponseStatusCodeSame(400);
        $this->assertJsonStringEqualsJsonString(
            json_encode(
                [
                    'errors' => [],
                    'message' => 'Credit application denied',
                ]
            ),
            $this->client->getResponse()->getContent()
        );
    }

    public function testCreditIssuanceIneligibleDueToLowFICOScore(): void
    {
        $client = $this->clientBuilder
            ->withFICOScore(400)
            ->build();

        $this->saveEntity($client);

        $this->client->jsonRequest(
            method: 'POST',
            uri: '/v1/credits',
            parameters: [
                'clientId' => $client->getId()->getValue(),
                'product' => 'personal',
                'amount' => 5000,
                'term' => 24
            ]
        );

        $this->assertResponseStatusCodeSame(400);
        $this->assertJsonStringEqualsJsonString(
            json_encode(
                [
                    'errors' => [],
                    'message' => 'Credit application denied',
                ]
            ),
            $this->client->getResponse()->getContent()
        );
    }

    public function testCreditIssuanceIneligibleDueToUnsupportedState(): void
    {
        $client = $this->clientBuilder
            ->withAddress('Dallas, TX 75201')
            ->build();

        $this->saveEntity($client);

        $this->client->jsonRequest(
            method: 'POST',
            uri: '/v1/credits',
            parameters: [
                'clientId' => $client->getId()->getValue(),
                'product' => 'personal',
                'amount' => 5000,
                'term' => 24
            ]
        );

        $this->assertResponseStatusCodeSame(400);
        $this->assertJsonStringEqualsJsonString(
            json_encode(
                [
                    'errors' => [],
                    'message' => 'Credit application denied',
                ]
            ),
            $this->client->getResponse()->getContent()
        );
    }

    private function getUrl(): string
    {
        return '/v1/credits';
    }

    private function getEventDispatcher(): RecordInMemoryEventDispatcher
    {
        return $this->client->getContainer()
            ->get(EventDispatcher::class);
    }
}
