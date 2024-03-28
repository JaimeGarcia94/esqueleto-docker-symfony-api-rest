<?php

declare(strict_types=1);

namespace App\Tests\Funtional\Controller;

use App\Tests\Funtional\ControllerTestBase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserControllerTest extends ControllerTestBase
{
    private const ENDPOINT_ALL_USERS = '/v1/users';
    private const ENDPOINT_USER = 'v1/user/{id}';
    private const ENDPOINT_CREATE_USER = 'v1/user/create';

    public function testAllUsers(): void
    {
        $this->client->request(Request::METHOD_GET, self::ENDPOINT_ALL_USERS);

        $response = $this->client->getResponse();

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    public function testUser(): void
    {
        $this->client->request(Request::METHOD_GET, self::ENDPOINT_USER);

        $response = $this->client->getResponse();

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    public function testCreateUser(): void
    {
        $this->client->request(Request::METHOD_POST, self::ENDPOINT_CREATE_USER);

        $response = $this->client->getResponse();

        var_dump($response->getStatusCode());
        die();

        // self::assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
    }
}
