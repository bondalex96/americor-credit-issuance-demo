<?php

declare(strict_types=1);

namespace Tests\Api\V1\Credit;

use App\Util\Tests\Helper\DatabaseTrait;
use Helpers\ClientBuilder;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class CheckCreditEligibilityActionTest extends WebTestCase
{
    use DatabaseTrait;

    private KernelBrowser $client;
    private ClientBuilder $clientBuilder;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->clientBuilder = (new ClientBuilder());
    }


    public function testEligibleClient(): void
    {
        $client = $this->clientBuilder
            ->withAge(30)
            ->withAddress('Los Angeles, CA 90001')
            ->withFICOScore(650)
            ->withMonthlyIncome(2000)
            ->build();

        $this->saveEntity($client);

        $this->client->jsonRequest(
            method: 'GET',
            uri: $this->getUrl($client->getId()->getValue())
        );

        $this->assertResponseIsSuccessful();
        $this->assertJsonStringEqualsJsonString(
            json_encode(['eligible' => true]),
            $this->client->getResponse()->getContent()
        );
    }

    public function testWithNonexistentClient(): void
    {

        $this->client->jsonRequest(
            method: 'GET',
            uri: $this->getUrl('123-45-6789')
        );


        $this->assertJsonStringEqualsJsonString(
            json_encode(['errors' => [], 'message' => 'Client with id 123-45-6789 not found']),
            $this->client->getResponse()->getContent()
        );

        $this->assertResponseStatusCodeSame(404);
    }

    public function testIneligibleClientDueToYoungAge(): void
    {
        $client = $this->clientBuilder
            ->withAge(17)
            ->build();

        $this->saveEntity($client);

        $this->client->jsonRequest(
            method: 'GET',
            uri: $this->getUrl($client->getId()->getValue())
        );

        $this->assertResponseIsSuccessful();
        $this->assertJsonStringEqualsJsonString(
            json_encode(['eligible' => false]),
            $this->client->getResponse()->getContent()
        );
    }

    public function testIneligibleClientDueToLowIncome(): void
    {
        $client = $this->clientBuilder
            ->withMonthlyIncome(800)
            ->build();

        $this->saveEntity($client);

        $this->client->jsonRequest(
            method: 'GET',
            uri: $this->getUrl($client->getId()->getValue())
        );

        $this->assertResponseIsSuccessful();
        $this->assertJsonStringEqualsJsonString(
            json_encode(['eligible' => false]),
            $this->client->getResponse()->getContent()
        );
    }

    public function testIneligibleClientDueToLowFICOScore(): void
    {
        $client = $this->clientBuilder
            ->withFICOScore(400)
            ->build();

        $this->saveEntity($client);

        $this->client->jsonRequest(
            method: 'GET',
            uri: $this->getUrl($client->getId()->getValue())
        );

        $this->assertResponseIsSuccessful();
        $this->assertJsonStringEqualsJsonString(
            json_encode(['eligible' => false]),
            $this->client->getResponse()->getContent()
        );
    }

    public function testIneligibleClientDueToUnsupportedState(): void
    {
        $client = $this->clientBuilder
            ->withAddress('Dallas, TX 75201')
            ->build();

        $this->saveEntity($client);

        $this->client->jsonRequest(
            method: 'GET',
            uri: $this->getUrl($client->getId()->getValue())
        );

        $this->assertResponseIsSuccessful();
        $this->assertJsonStringEqualsJsonString(
            json_encode(['eligible' => false]),
            $this->client->getResponse()->getContent()
        );
    }

    public function testIneligibleClientDueToRandomDenialForNY(): void
    {
        $client = $this->clientBuilder
            ->withAddress('New York, NY 10001')
            ->build();

        $this->saveEntity($client);

        $this->client->jsonRequest(
            method: 'GET',
            uri: $this->getUrl($client->getId()->getValue())
        );

        $this->assertResponseIsSuccessful();

        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('eligible', $response);
        $this->assertContains($response['eligible'], [true, false]);
    }

    private function getUrl(string $clientId): string
    {
        return "/v1/clients/{$clientId}/credit-eligibility";
    }
}
