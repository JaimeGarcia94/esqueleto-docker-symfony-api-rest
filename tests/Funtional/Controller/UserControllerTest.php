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
    private const ENDPOINT_UPDATE_USER = 'v1/user/update/{id}';
    private const ENDPOINT_DELETE_USER = 'v1/user/delete/{id}';

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
        $responseData = \json_decode($response->getContent(), true);

        if($response->getStatusCode() !== 400) {
            self::assertNotEmpty($this->data["email"], 'Has data');
            self::assertNotEmpty($this->data["name"], 'Has data');
            self::assertRegExp('/^.+\@\S+\.\S+$/', $this->data["email"]);
            self::assertIsString($this->data["name"], 'Name is string');
            self::assertEquals('El usuario se ha creado correctamente', $responseData['msg']);
            self::assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        } else {
            self::assertEquals('No se puede crear un usuario sin: email o name. Revise los datos a introducir', $responseData['msgError']);
            self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        }
    }

    public function testUpdateUser(): void
    {
        $this->client->request(Request::METHOD_PUT, self::ENDPOINT_UPDATE_USER);

        $response = $this->client->getResponse();

        if($response->getStatusCode() !== 400) {
            self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        } else {
            self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        }
    }

    public function testDeleteUser(): void
    {
        $this->client->request(Request::METHOD_DELETE, self::ENDPOINT_DELETE_USER);

        $response = $this->client->getResponse();

        if($response->getStatusCode() !== 400) {
            self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        } else {
            self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        }
    }
}
