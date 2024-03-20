<?php

namespace Tests\Unit\Domain\Services;

use Domain\Model\Movie;
use PHPUnit\Framework\TestCase;

class MoviesServiceTest extends TestCase
{
    public function testGetters(): void
    {
        $movie = new Movie(
            1,
            'Test Movie',
            'This is a test movie',
            '2024-01-01',
            '/poster.jpg',
            [1, 2, 3]
        );

        $this->assertEquals(1, $movie->getId());
        $this->assertEquals('Test Movie', $movie->getTitle());
        $this->assertEquals('This is a test movie', $movie->getOverview());
        $this->assertEquals('2024-01-01', $movie->getReleaseDate());
        $this->assertEquals('/poster.jpg', $movie->getPosterPath());
        $this->assertEquals([1, 2, 3], $movie->getGenreIds());
    }

    public function testToArray(): void
    {
        $movie = new Movie(
            1,
            'Test Movie',
            'This is a test movie',
            '2024-01-01',
            '/poster.jpg',
            [1, 2, 3]
        );

        $expectedArray = [
            'id' => 1,
            'title' => 'Test Movie',
            'overview' => 'This is a test movie',
            'releaseDate' => '2024-01-01',
            'posterPath' => '/poster.jpg',
            'genreIds' => [1, 2, 3],
        ];

        $this->assertEquals($expectedArray, $movie->toArray());
    }
}
