<?php

declare(strict_types=1);

namespace App\Tests\Funtional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\AbstractBrowser;

class ControllerTestBase extends WebTestCase
{
    protected ?AbstractBrowser $client;

    public function setUp(): void
    {
        $this->client = static::createClient();
        $this->client->setServerParameter('CONTENT_TYPE', 'application/json');
    }

    public function tearDown(): void
    {
        self::ensureKernelShutdown();
    }
}
