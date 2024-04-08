<?php

namespace App\Tests\Funtional\Controller;

use App\Tests\Funtional\ControllerTestBase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class WorkEntryControllerTest extends ControllerTestBase
{
    private const ENDPOINT_ALL_WORKS_ENTRIES = 'v1/works-entries';
    private const ENDPOINT_WORK_ENTRY = 'v1/work-entry/{id}';
    private const ENDPOINT_CREATE_WORK_ENTRY = 'v1/work-entry/create';
    private const ENDPOINT_UPDATE_WORK_ENTRY = 'v1/work-entry/update/{id}';
    private const ENDPOINT_DELETE_WORK_ENTRY = 'v1/work-entry/delete/{id}';

    public function testAllWorksEntries(): void
    {
        $this->client->request(Request::METHOD_GET, self::ENDPOINT_ALL_WORKS_ENTRIES);

        $response = $this->client->getResponse();

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    public function testWorkEntry(): void
    {
        $this->client->request(Request::METHOD_GET, self::ENDPOINT_WORK_ENTRY);

        $response = $this->client->getResponse();
        $responseData = \json_decode($response->getContent(), true);

        if($response->getStatusCode() !== 400) {
            self::assertNotEmpty($this->data["id"], 'Has data');
            self::assertIsInt($this->data["id"], 'Id is a integer');
            self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        } else {
            self::assertEquals('There is no date record in the DB with this ID. Please enter a valid one', $responseData['msgError']);
            self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        }
    }

    public function testCreateWorkEntry(): void
    {
        $this->client->request(Request::METHOD_POST, self::ENDPOINT_CREATE_WORK_ENTRY);

        $response = $this->client->getResponse();
        $responseData = \json_decode($response->getContent(), true);

        if($response->getStatusCode() !== 400) {
            self::assertNotEmpty($this->data["userId"], 'Has data');
            self::assertIsInt($this->data["userId"], 'UserId is a integer');
            self::assertEquals('The date has been created correctly', $responseData['msg']);
            self::assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        } else {
            self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        }
    }

    public function testUpdateWorkEntry(): void
    {
        $this->client->request(Request::METHOD_PUT, self::ENDPOINT_UPDATE_WORK_ENTRY);

        $response = $this->client->getResponse();
        $responseData = \json_decode($response->getContent(), true);

        if($response->getStatusCode() !== 400) {
            self::assertNotEmpty($this->data["id"], 'Has data');
            self::assertIsInt($this->data["id"], 'Id is a integer');
            self::assertEquals('The date has been updated correctly', $responseData['msg']);
            self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        } else {
            self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        }
    }

    public function testDeleteWorkEntry(): void
    {
        $this->client->request(Request::METHOD_DELETE, self::ENDPOINT_DELETE_WORK_ENTRY);

        $response = $this->client->getResponse();
        $responseData = \json_decode($response->getContent(), true);

        if($response->getStatusCode() !== 400) {
            self::assertNotEmpty($this->data["id"], 'Has data');
            self::assertIsInt($this->data["id"], 'Id is a integer');
            self::assertEquals('The record has been successfully deleted', $responseData['msg']);
            self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        } else {
            self::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        }
    }
}
