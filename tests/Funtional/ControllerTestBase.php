<?php

declare(strict_types=1);

namespace App\Tests\Funtional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\AbstractBrowser;
use DateTime;

class ControllerTestBase extends WebTestCase
{
    protected ?AbstractBrowser $client;
    protected $data;

    public function setUp(): void
    {
        $this->client = static::createClient();
        $this->client->setServerParameter('CONTENT_TYPE', 'application/json');

        $this->data = [
            'id' => 1,
            'email' => 'prueba@gmail.com',
            'name' => 'jaime',
            'date' => new DateTime(),
        ];
    }

    public function tearDown(): void
    {
        self::ensureKernelShutdown();
    }
}
