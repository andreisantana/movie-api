<?php

namespace Tests\EndToEnd;

use PHPUnit\Framework\TestCase;

class MoviesEndToEndTest extends TestCase
{
    private const BASE_URL = 'http://nginx:80';

    private function getRequest($url)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    public function testUpcomingMoviesRoute(): void
    {
        $response = $this->getRequest(self::BASE_URL . '/upcoming');
        $this->assertNotEmpty($response);
        $this->assertJson($response);
    }

    public function testUpcomingMoviesSecondPageRoute(): void
    {
        $response = $this->getRequest(self::BASE_URL . '/upcoming?page=2');
        $this->assertNotEmpty($response);
        $this->assertJson($response);
    }

    public function testTopRatedMoviesRoute(): void
    {
        $response = $this->getRequest(self::BASE_URL . '/top_rated');
        $this->assertNotEmpty($response);
        $this->assertJson($response);
    }

    public function testTopRatedMoviesFourthPageRoute(): void
    {
        $response = $this->getRequest(self::BASE_URL . '/top_rated?page=4');
        $this->assertNotEmpty($response);
        $this->assertJson($response);
    }

    public function testMovieByIdRoute(): void
    {
        $response = $this->getRequest(self::BASE_URL . '/movies/76341');
        $this->assertNotEmpty($response);
        $this->assertJson($response);
    }

    public function testMovieByIdWithSimilarMoviesRoute(): void
    {
        $response = $this->getRequest(self::BASE_URL . '/movies/76341/similar');
        $this->assertNotEmpty($response);
        $this->assertJson($response);
    }

    public function testMovieByIdWithSimilarMoviesFifthPageRoute(): void
    {
        $response = $this->getRequest(self::BASE_URL . '/movies/76341/similar?page=5');
        $this->assertNotEmpty($response);
        $this->assertJson($response);
    }

    public function testMovieByQueryRoute(): void
    {
        $response = $this->getRequest(self::BASE_URL . '/search?movie=mad');
        $this->assertNotEmpty($response);
        $this->assertJson($response);
    }

    public function testGenreRoute(): void
    {
        $response = $this->getRequest(self::BASE_URL . '/genres');
        $this->assertNotEmpty($response);
        $this->assertJson($response);
    }
}
