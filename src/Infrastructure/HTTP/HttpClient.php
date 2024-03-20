<?php

namespace Infrastructure\HTTP;

class HttpClient
{
    public function get(string $url): ?string
    {
        $response = @file_get_contents($url);

        if ($response === false) {
            throw new \RuntimeException('Failed to fetch URL: ' . $url);
        }

        return $response;
    }
}
