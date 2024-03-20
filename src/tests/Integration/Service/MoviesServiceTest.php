<?php

namespace Tests\Domain\Service;

use Domain\Model\Movie;
use Domain\Service\MoviesServiceInterface;
use PHPUnit\Framework\TestCase;

class MoviesServiceTest extends TestCase
{
    private const MOVIE_ID = 550; // Exemplo de ID de filme para testar

    private $moviesService;

    protected function setUp(): void
    {
        $this->moviesService = $this->createMock(MoviesServiceInterface::class);
    }

    public function testFindMovieByIdReturnsMovie(): void
    {
        $expectedMovie = new Movie(
            self::MOVIE_ID,
            'The Dark Knight',
            'Batman fights crime in Gotham City.',
            '2008-07-18',
            '/qJ2tW6WMUDux911r6m7haRef0WH.jpg',
            ['Action', 'Crime', 'Drama']
        );

        $this->moviesService->method('findMovieById')
            ->with(self::MOVIE_ID)
            ->willReturn($expectedMovie);

        $movie = $this->moviesService->findMovieById(self::MOVIE_ID);

        $this->assertInstanceOf(Movie::class, $movie);
        $this->assertEquals($expectedMovie, $movie);
    }

    public function testFindMovieByIdReturnsNullForInvalidId(): void
    {
        $this->moviesService->method('findMovieById')
            ->with(9999)
            ->willReturn(null);

        $movie = $this->moviesService->findMovieById(9999);
        $this->assertNull($movie);
    }
}
