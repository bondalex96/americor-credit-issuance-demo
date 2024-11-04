<?php

declare(strict_types=1);

namespace Tests\Api\V1\Client;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class CreateActionTest extends WebTestCase
{
    private KernelBrowser $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function testCreateClientSuccessfully(): void
    {
        $this->client->jsonRequest(
            method: 'POST',
            uri: '/v1/clients',
            parameters: [
                'lastName' => 'Doe',
                'firstName' => 'John',
                'age' => 30,
                'address' => 'New York, NY 10001',
                'ssn' => '123-45-6789',
                'fico' => 700,
                'email' => 'johndoe@example.com',
                'phoneNumber' => '+1-123-456-7890',
                'monthlyIncome' => 5000,
            ]
        );

        $this->assertResponseIsSuccessful();
    }

    public function testCreateClientWithExistingSSN(): void
    {
        $this->client->jsonRequest(
            method: 'POST',
            uri: '/v1/clients',
            parameters: [
                'lastName' => 'Doe',
                'firstName' => 'John',
                'age' => 30,
                'address' => 'New York, NY 10001',
                'ssn' => '123-45-6789',
                'fico' => 700,
                'email' => 'johndoe@example.com',
                'phoneNumber' => '+1-123-456-7890',
                'monthlyIncome' => 5000,
            ]
        );

        $this->assertResponseIsSuccessful();

        $this->client->jsonRequest(
            method: 'POST',
            uri: '/v1/clients',
            parameters: [
                'lastName' => 'Doe',
                'firstName' => 'John',
                'age' => 30,
                'address' => 'New York, NY 10001',
                'ssn' => '123-45-6789',
                'fico' => 700,
                'email' => 'johndoe@example.com',
                'phoneNumber' => '+1-123-456-7890',
                'monthlyIncome' => 5000,
            ]
        );

        $this->assertResponseStatusCodeSame(400);
        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'errors' => [],
                'message' => 'Client with this SSN already exists.']),
            $this->client->getResponse()->getContent()
        );
    }

    public function testCreateClientWithEmptyRequestBody(): void
    {
        $this->client->jsonRequest(
            method: 'POST',
            uri: '/v1/clients',
            parameters: []
        );

        $this->assertResponseStatusCodeSame(422);
        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'errors' => [
                    'lastName' => 'This value should be of type string.',
                    'firstName' => 'This value should be of type string.',
                    'age' => 'This value should be of type int.',
                    'address' => 'This value should be of type string.',
                    'ssn' => 'This value should be of type string.',
                    'fico' => 'This value should be of type int.',
                    'email' => 'This value should be of type string.',
                    'phoneNumber' => 'This value should be of type string.',
                    'monthlyIncome' => 'This value should be of type float.'
                ],
                'message' => 'Invalid request data.'
            ]),
            $this->client->getResponse()->getContent()
        );
    }

    public function testCreateClientWithEmptyLastName(): void
    {
        $this->client->jsonRequest(
            method: 'POST',
            uri: '/v1/clients',
            parameters:                 [
                'lastName' => '',
                'firstName' => 'John',
                'age' => 30,
                'address' => '123 Main St, Anytown, USA',
                'ssn' => '123-45-6789',
                'fico' => 700,
                'email' => 'johndoe@example.com',
                'phoneNumber' => '+1-123-456-7890',
                'monthlyIncome' => 5000,
            ]
        );

        $this->assertResponseStatusCodeSame(422);
        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'errors' => [
                    'lastName' => 'This value should not be blank.',
                ],
                'message' => 'Invalid request data.'
            ]),
            $this->client->getResponse()->getContent()
        );
    }


    public function testCreateClientWithNonStringLastName(): void
    {
        $parameters = [
            'lastName' => 123,
            'firstName' => 'John',
            'age' => 30,
            'address' => '123 Main St, Anytown, USA',
            'ssn' => '123-45-6789',
            'fico' => 700,
            'email' => 'johndoe@example.com',
            'phoneNumber' => '+1-123-456-7890',
            'monthlyIncome' => 5000,
        ];
        $expectedResponse = [
            'errors' => [
                'lastName' => 'This value should be of type string.',
            ],
            'message' => 'Invalid request data.'
        ];

        $this->client->jsonRequest(
            method: 'POST',
            uri: '/v1/clients',
            parameters: $parameters
        );

        $this->assertResponseStatusCodeSame(422);
        $this->assertJsonStringEqualsJsonString(
            json_encode($expectedResponse),
            $this->client->getResponse()->getContent()
        );
    }

    public function testCreateClientWithEmptyFirstName(): void
    {
        $parameters = [
            'lastName' => 'Doe',
            'firstName' => '',
            'age' => 30,
            'address' => '123 Main St, Anytown, USA',
            'ssn' => '123-45-6789',
            'fico' => 700,
            'email' => 'johndoe@example.com',
            'phoneNumber' => '+1-123-456-7890',
            'monthlyIncome' => 5000,
        ];
        $expectedResponse = [
            'errors' => [
                'firstName' => 'This value should not be blank.',
            ],
            'message' => 'Invalid request data.'
        ];

        $this->client->jsonRequest(
            method: 'POST',
            uri: '/v1/clients',
            parameters: $parameters
        );

        $this->assertResponseStatusCodeSame(422);
        $this->assertJsonStringEqualsJsonString(
            json_encode($expectedResponse),
            $this->client->getResponse()->getContent()
        );
    }

    public function testCreateClientWithNonStringFirstName(): void
    {
        $parameters = [
            'lastName' => 'Doe',
            'firstName' => 123,
            'age' => 30,
            'address' => '123 Main St, Anytown, USA',
            'ssn' => '123-45-6789',
            'fico' => 700,
            'email' => 'johndoe@example.com',
            'phoneNumber' => '+1-123-456-7890',
            'monthlyIncome' => 5000,
        ];
        $expectedResponse = [
            'errors' => [
                'firstName' => 'This value should be of type string.',
            ],
            'message' => 'Invalid request data.'
        ];

        $this->client->jsonRequest(
            method: 'POST',
            uri: '/v1/clients',
            parameters: $parameters
        );

        $this->assertResponseStatusCodeSame(422);
        $this->assertJsonStringEqualsJsonString(
            json_encode($expectedResponse),
            $this->client->getResponse()->getContent()
        );
    }

    public function testCreateClientWithStringAge(): void
    {
        $parameters = [
            'lastName' => 'Doe',
            'firstName' => 'John',
            'age' => 'thirty',
            'address' => '123 Main St, Anytown, USA',
            'ssn' => '123-45-6789',
            'fico' => 700,
            'email' => 'johndoe@example.com',
            'phoneNumber' => '+1-123-456-7890',
            'monthlyIncome' => 5000,
        ];
        $expectedResponse = [
            'errors' => [
                'age' => 'This value should be of type int.',
            ],
            'message' => 'Invalid request data.'
        ];

        $this->client->jsonRequest(
            method: 'POST',
            uri: '/v1/clients',
            parameters: $parameters
        );

        $this->assertResponseStatusCodeSame(422);
        $this->assertJsonStringEqualsJsonString(
            json_encode($expectedResponse),
            $this->client->getResponse()->getContent()
        );
    }

    public function testCreateClientWithNegativeAge(): void
    {
        $parameters = [
            'lastName' => 'Doe',
            'firstName' => 'John',
            'age' => -1,
            'address' => '123 Main St, Anytown, USA',
            'ssn' => '123-45-6789',
            'fico' => 700,
            'email' => 'johndoe@example.com',
            'phoneNumber' => '+1-123-456-7890',
            'monthlyIncome' => 5000,
        ];
        $expectedResponse = [
            'errors' => [
                'age' => 'This value should be positive.',
            ],
            'message' => 'Invalid request data.'
        ];

        $this->client->jsonRequest(
            method: 'POST',
            uri: '/v1/clients',
            parameters: $parameters
        );

        $this->assertResponseStatusCodeSame(422);
        $this->assertJsonStringEqualsJsonString(
            json_encode($expectedResponse),
            $this->client->getResponse()->getContent()
        );
    }

    public function testCreateClientWithEmptyAddress(): void
    {

        $this->client->jsonRequest(
            method: 'POST',
            uri: '/v1/clients',
            parameters: [
                'lastName' => 'Doe',
                'firstName' => 'John',
                'age' => 30,
                'address' => '',
                'ssn' => '123-45-6789',
                'fico' => 700,
                'email' => 'johndoe@example.com',
                'phoneNumber' => '+1-123-456-7890',
                'monthlyIncome' => 5000,
            ]
        );

        $this->assertResponseStatusCodeSame(422);
        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'errors' => [
                    'address' => 'This value should not be blank.',
                ],
                'message' => 'Invalid request data.'
            ]),
            $this->client->getResponse()->getContent()
        );
    }

    public function testCreateClientWithEmptySsn(): void
    {

        $this->client->jsonRequest(
            method: 'POST',
            uri: '/v1/clients',
            parameters: [
                'lastName' => 'Doe',
                'firstName' => 'John',
                'age' => 30,
                'address' => '123 Main St, Anytown, USA',
                'ssn' => '',
                'fico' => 700,
                'email' => 'johndoe@example.com',
                'phoneNumber' => '+1-123-456-7890',
                'monthlyIncome' => 5000,
            ]
        );

        $this->assertResponseStatusCodeSame(422);
        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'errors' => [
                    'ssn' => 'This value should not be blank.',
                ],
                'message' => 'Invalid request data.'
            ]),
            $this->client->getResponse()->getContent()
        );
    }

    public function testCreateClientWithInvalidSsnFormat(): void
    {
        $this->client->jsonRequest(
            method: 'POST',
            uri: '/v1/clients',
            parameters: [
                'lastName' => 'Doe',
                'firstName' => 'John',
                'age' => 30,
                'address' => '123 Main St, Anytown, USA',
                'ssn' => 'invalid-ssn',
                'fico' => 700,
                'email' => 'johndoe@example.com',
                'phoneNumber' => '+1-123-456-7890',
                'monthlyIncome' => 5000,
            ]
        );

        $this->assertResponseStatusCodeSame(422);
        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'errors' => [
                    'ssn' => 'This value is not valid.',
                ],
                'message' => 'Invalid request data.'
            ]),
            $this->client->getResponse()->getContent()
        );
    }

    public function testCreateClientWithEmptyFico(): void
    {

        $this->client->jsonRequest(
            method: 'POST',
            uri: '/v1/clients',
            parameters: [
                'lastName' => 'Doe',
                'firstName' => 'John',
                'age' => 30,
                'address' => '123 Main St, Anytown, USA',
                'ssn' => '123-45-6789',
                'fico' => '',
                'email' => 'johndoe@example.com',
                'phoneNumber' => '+1-123-456-7890',
                'monthlyIncome' => 5000,
            ]
        );

        $this->assertResponseStatusCodeSame(422);
        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'errors' => [
                    'fico' => 'This value should be of type int.',
                ],
                'message' => 'Invalid request data.'
            ]),
            $this->client->getResponse()->getContent()
        );
    }

    public function testCreateClientWithInvalidFicoType(): void
    {
        $this->client->jsonRequest(
            method: 'POST',
            uri: '/v1/clients',
            parameters: [
                'lastName' => 'Doe',
                'firstName' => 'John',
                'age' => 30,
                'address' => '123 Main St, Anytown, USA',
                'ssn' => '123-45-6789',
                'fico' => 'seven hundred',
                'email' => 'johndoe@example.com',
                'phoneNumber' => '+1-123-456-7890',
                'monthlyIncome' => 5000,
            ]
        );

        $this->assertResponseStatusCodeSame(422);
        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'errors' => [
                    'fico' => 'This value should be of type int.',
                ],
                'message' => 'Invalid request data.'
            ]),
            $this->client->getResponse()->getContent()
        );
    }

    public function testCreateClientWithEmptyEmail(): void
    {

        $this->client->jsonRequest(
            method: 'POST',
            uri: '/v1/clients',
            parameters: [
                'lastName' => 'Doe',
                'firstName' => 'John',
                'age' => 30,
                'address' => '123 Main St, Anytown, USA',
                'ssn' => '123-45-6789',
                'fico' => 700,
                'email' => '',
                'phoneNumber' => '+1-123-456-7890',
                'monthlyIncome' => 5000,
            ]
        );

        $this->assertResponseStatusCodeSame(422);
        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'errors' => [
                    'email' => 'This value should not be blank.',
                ],
                'message' => 'Invalid request data.'
            ]),
            $this->client->getResponse()->getContent()
        );
    }

    public function testCreateClientWithInvalidEmailFormat(): void
    {

        $this->client->jsonRequest(
            method: 'POST',
            uri: '/v1/clients',
            parameters: [
                'lastName' => 'Doe',
                'firstName' => 'John',
                'age' => 30,
                'address' => '123 Main St, Anytown, USA',
                'ssn' => '123-45-6789',
                'fico' => 700,
                'email' => 'invalid-email',
                'phoneNumber' => '+1-123-456-7890',
                'monthlyIncome' => 5000,
            ]
        );

        $this->assertResponseStatusCodeSame(422);
        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'errors' => [
                    'email' => 'This value is not a valid email address.',
                ],
                'message' => 'Invalid request data.'
            ]),
            $this->client->getResponse()->getContent()
        );
    }

    public function testCreateClientWithEmptyPhoneNumber(): void
    {
        $this->client->jsonRequest(
            method: 'POST',
            uri: '/v1/clients',
            parameters: [
                'lastName' => 'Doe',
                'firstName' => 'John',
                'age' => 30,
                'address' => '123 Main St, Anytown, USA',
                'ssn' => '123-45-6789',
                'fico' => 700,
                'email' => 'johndoe@example.com',
                'phoneNumber' => '',
                'monthlyIncome' => 5000,
            ]
        );

        $this->assertResponseStatusCodeSame(422);
        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'errors' => [
                    'phoneNumber' => 'This value should not be blank.',
                ],
                'message' => 'Invalid request data.'

            ]),
            $this->client->getResponse()->getContent()
        );
    }

    public function testCreateClientWithInvalidPhoneNumberFormat(): void
    {

        $this->client->jsonRequest(
            method: 'POST',
            uri: '/v1/clients',
            parameters: [
                'lastName' => 'Doe',
                'firstName' => 'John',
                'age' => 30,
                'address' => '123 Main St, Anytown, USA',
                'ssn' => '123-45-6789',
                'fico' => 700,
                'email' => 'johndoe@example.com',
                'phoneNumber' => 'invalid-phone',
                'monthlyIncome' => 5000,
            ]
        );

        $this->assertResponseStatusCodeSame(422);
        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'errors' => [
                    'phoneNumber' => 'This value is not valid.',
                ],
                'message' => 'Invalid request data.'
            ]),
            $this->client->getResponse()->getContent()
        );
    }

    public function testCreateClientWithEmptyMonthlyIncome(): void
    {
        $parameters = [
            'lastName' => 'Doe',
            'firstName' => 'John',
            'age' => 30,
            'address' => '123 Main St, Anytown, USA',
            'ssn' => '123-45-6789',
            'fico' => 700,
            'email' => 'johndoe@example.com',
            'phoneNumber' => '+1-123-456-7890',
            'monthlyIncome' => '',
        ];
        $expectedResponse = [
            'errors' => [
                'monthlyIncome' => 'This value should be of type float.',
            ],
            'message' => 'Invalid request data.'
        ];

        $this->client->jsonRequest(
            method: 'POST',
            uri: '/v1/clients',
            parameters: $parameters
        );

        $this->assertResponseStatusCodeSame(422);
        $this->assertJsonStringEqualsJsonString(
            json_encode($expectedResponse),
            $this->client->getResponse()->getContent()
        );
    }

    public function testCreateClientWithNonNumericMonthlyIncome(): void
    {
        $this->client->jsonRequest(
            method: 'POST',
            uri: '/v1/clients',
            parameters: [
                'lastName' => 'Doe',
                'firstName' => 'John',
                'age' => 30,
                'address' => '123 Main St, Anytown, USA',
                'ssn' => '123-45-6789',
                'fico' => 700,
                'email' => 'johndoe@example.com',
                'phoneNumber' => '+1-123-456-7890',
                'monthlyIncome' => 'five thousand',
            ]
        );

        $this->assertResponseStatusCodeSame(422);
        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'errors' => [
                    'monthlyIncome' => 'This value should be of type float.',
                ],
                'message' => 'Invalid request data.'
            ]),
            $this->client->getResponse()->getContent()
        );
    }

    public function testCreateClientWithNegativeMonthlyIncome(): void
    {
        $this->client->jsonRequest(
            method: 'POST',
            uri: '/v1/clients',
            parameters: [
                'lastName' => 'Doe',
                'firstName' => 'John',
                'age' => 30,
                'address' => '123 Main St, Anytown, USA',
                'ssn' => '123-45-6789',
                'fico' => 700,
                'email' => 'johndoe@example.com',
                'phoneNumber' => '+1-123-456-7890',
                'monthlyIncome' => -5000,
            ]
        );

        $this->assertResponseStatusCodeSame(422);
        $this->assertSame(
            [
                'errors' => [
                    'monthlyIncome' => 'This value should be positive.',
                ],
                'message' => 'Invalid request data.'
            ],
            json_decode($this->client->getResponse()->getContent(), true)
        );
    }
}
