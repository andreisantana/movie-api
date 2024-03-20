<?php

namespace Tests\Unit\API;

use PHPUnit\Framework\TestCase;
use Infrastructure\HTTP\HttpClient;

class HttpClientTest extends TestCase
{
    public function testGetWithValidUrl(): void
    {
        $httpClient = new HttpClient();
        $url = 'https://example.com';
        $response = $httpClient->get($url);

        $this->assertNotNull($response);
        $this->assertIsString($response);
    }

    public function testGetWithInvalidUrl(): void
    {
        $httpClient = new HttpClient();
        $url = 'https://invalid-url';

        $this->expectException(\RuntimeException::class);
        $httpClient->get($url);
    }
}
