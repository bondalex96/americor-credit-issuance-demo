<?php

declare(strict_types=1);

namespace Tests\Api\V1\Client;

use App\Util\Tests\Helper\DatabaseTrait;
use Helpers\ClientBuilder;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class UpdateActionTest extends WebTestCase
{
    use DatabaseTrait;

    private KernelBrowser $client;
    private ClientBuilder $clientBuilder;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->clientBuilder = (new ClientBuilder())
            ->withAge(30)
            ->withAddress('Los Angeles, CA 90001')
            ->withFICOScore(650)
            ->withMonthlyIncome(2000)
            ->withSSN('123-45-6789');
    }

    public function testUpdateClientSuccessfully(): void
    {
        $clientBuilder = new ClientBuilder();
        $client = $clientBuilder
            ->withAge(30)
            ->withAddress('Los Angeles, CA 90001')
            ->withFICOScore(650)
            ->withMonthlyIncome(2000)
            ->withSSN('123-45-6789')
            ->build();

        $this->saveEntity($client);

        $this->client->jsonRequest(
            method: 'PATCH',
            uri: '/v1/clients/123-45-6789',
            parameters: [
                'lastName' => 'Doe',
                'firstName' => 'John',
                'age' => 30,
                'address' => 'New York, NY 10001',
                'fico' => 750,
                'email' => 'johnupdated@example.com',
                'phoneNumber' => '+1-123-456-7891',
                'monthlyIncome' => 6000,
            ]
        );

        $this->assertResponseStatusCodeSame(204);
    }

    public function testUpdateNonExistingClient(): void
    {
        $this->client->jsonRequest(
            method: 'PATCH',
            uri: '/v1/clients/non-existing-ssn',
            parameters: [
                'lastName' => 'Doe',
                'firstName' => 'John',
                'age' => 30,
                'address' => 'New York, NY 10001',
                'fico' => 750,
                'email' => 'johnupdated@example.com',
                'phoneNumber' => '+1-123-456-7891',
                'monthlyIncome' => 6000,
            ]
        );

        $this->assertResponseStatusCodeSame(400);
        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'errors' => [],
                'message' => 'Client with this SSN does not exist.']),
            $this->client->getResponse()->getContent()
        );
    }

    public function testUpdateClientWithEmptyLastName(): void
    {
        $client = $this->clientBuilder
            ->build();

        $this->saveEntity($client);

        $this->client->jsonRequest(
            method: 'PATCH',
            uri: '/v1/clients/123-45-6789',
            parameters: [
                'lastName' => '',
                'firstName' => 'John',
                'age' => 30,
                'address' => 'New York, NY 10001',
                'fico' => 750,
                'email' => 'johnupdated@example.com',
                'phoneNumber' => '+1-123-456-7891',
                'monthlyIncome' => 6000,
            ]
        );

        $this->assertResponseStatusCodeSame(422);
        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'errors' => [
                    'lastName' => 'This value should not be blank.'
                ],
                'message' => 'Invalid request data.'
            ]),
            $this->client->getResponse()->getContent()
        );
    }

    public function testUpdateClientWithInvalidEmail(): void
    {
        $client = $this->clientBuilder
            ->build();

        $this->saveEntity($client);

        $this->client->jsonRequest(
            method: 'PATCH',
            uri: '/v1/clients/123-45-6789',
            parameters: [
                'lastName' => 'Doe',
                'firstName' => 'John',
                'age' => 30,
                'address' => 'New York, NY 10001',
                'fico' => 750,
                'email' => 'invalid-email',
                'phoneNumber' => '+1-123-456-7891',
                'monthlyIncome' => 6000,
            ]
        );

        $this->assertResponseStatusCodeSame(422);
        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'errors' => [
                    'email' => 'This value is not a valid email address.'
                ],
                'message' => 'Invalid request data.'
            ]),
            $this->client->getResponse()->getContent()
        );
    }

    public function testUpdateClientWithNegativeAge(): void
    {
        $client = $this->clientBuilder
            ->build();

        $this->saveEntity($client);

        $this->client->jsonRequest(
            method: 'PATCH',
            uri: '/v1/clients/123-45-6789',
            parameters: [
                'lastName' => 'Doe',
                'firstName' => 'John',
                'age' => -1,
                'address' => 'New York, NY 10001',
                'fico' => 750,
                'email' => 'johnupdated@example.com',
                'phoneNumber' => '+1-123-456-7891',
                'monthlyIncome' => 6000,
            ]
        );

        $this->assertResponseStatusCodeSame(422);
        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'errors' => [
                    'age' => 'This value should be positive.'
                ],
                'message' => 'Invalid request data.'
            ]),
            $this->client->getResponse()->getContent()
        );
    }

    public function testUpdateClientWithoutFICO(): void
    {
        $client = $this->clientBuilder
            ->build();

        $this->saveEntity($client);

        $this->client->jsonRequest(
            method: 'PATCH',
            uri: '/v1/clients/123-45-6789',
            parameters: [
                'lastName' => 'Doe',
                'firstName' => 'John',
                'age' => 30,
                'address' => 'New York, NY 10001',
                'email' => 'johnupdated@example.com',
                'phoneNumber' => '+1-123-456-7891',
                'monthlyIncome' => 6000,
            ]
        );

        $this->assertResponseStatusCodeSame(422);
        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'errors' => [
                    'fico' => 'This value should be of type int.'
                ],
                'message' => 'Invalid request data.'
            ]),
            $this->client->getResponse()->getContent()
        );
    }

    public function testUpdateClientWithNegativeMonthlyIncome(): void
    {
        $client = $this->clientBuilder
            ->build();

        $this->saveEntity($client);

        $this->client->jsonRequest(
            method: 'PATCH',
            uri: '/v1/clients/123-45-6789',
            parameters: [
                'lastName' => 'Doe',
                'firstName' => 'John',
                'age' => 30,
                'address' => 'New York, NY 10001',
                'fico' => 750,
                'email' => 'johnupdated@example.com',
                'phoneNumber' => '+1-123-456-7891',
                'monthlyIncome' => -1,
            ]
        );

        $this->assertResponseStatusCodeSame(422);
        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'errors' => [
                    'monthlyIncome' => 'This value should be positive.'
                ],
                'message' => 'Invalid request data.'
            ]),
            $this->client->getResponse()->getContent()
        );
    }
}
