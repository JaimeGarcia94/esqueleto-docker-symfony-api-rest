<?php

namespace App\Tests\Funtional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserControllerTest extends WebTestCase
{
    private const ENDPOINT_ALL_USERS = '/v1/users';

    public function testAllUsers(): void
    {
        $client = static::createClient();
        $client->request(Request::METHOD_GET, self::ENDPOINT_ALL_USERS);

        $response = $client->getResponse();

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }
}
