<?php

namespace Tests\Unit\Application\Services;


use Application\Services\MoviesService;
use Domain\Repository\MoviesRepositoryInterface;
use Domain\Model\Movie;
use PHPUnit\Framework\TestCase;

class MoviesServiceTest extends TestCase
{
    public function testFindByIdCallsRepository(): void
    {
        $mockRepository = $this->createMock(MoviesRepositoryInterface::class);

        $movieId = 123;
        $expectedMovie = new Movie($movieId, 'Movie Title', 'Movie Overview', '2024-03-12', '/path/to/poster', [1, 2]);
        $mockRepository->expects($this->once())
            ->method('findById')
            ->with($movieId)
            ->willReturn($expectedMovie);

        $moviesService = new MoviesService($mockRepository);

        $result = $moviesService->findById($movieId);

        $this->assertEquals($expectedMovie, $result);
    }

    public function testFindByTitleCallsRepository(): void
    {
        $mockRepository = $this->createMock(MoviesRepositoryInterface::class);

        $title = 'Sample Movie Title';

        $expectedMovies = [
            ['id' => 1, 'title' => 'Sample Movie 1'],
            ['id' => 2, 'title' => 'Sample Movie 2'],
            ['id' => 3, 'title' => 'Sample Movie 3']
        ];
        $mockRepository->expects($this->once())
            ->method('findByTitle')
            ->with($title)
            ->willReturn($expectedMovies);

        $moviesService = new MoviesService($mockRepository);

        $result = $moviesService->findByTitle($title);

        $this->assertEquals($expectedMovies, $result);
    }

    public function testFindUpcomingMoviesCallsRepository(): void
    {
        $mockRepository = $this->createMock(MoviesRepositoryInterface::class);

        $page = 2;

        $expectedMovies = [
            ['id' => 1, 'title' => 'Sample Movie 1'],
            ['id' => 2, 'title' => 'Sample Movie 2'],
            ['id' => 3, 'title' => 'Sample Movie 3']
        ];
        $mockRepository->expects($this->once())
            ->method('findUpcomingMovies')
            ->with($page)
            ->willReturn($expectedMovies);

        $moviesService = new MoviesService($mockRepository);

        $result = $moviesService->findUpcomingMovies($page);

        $this->assertEquals($expectedMovies, $result);
    }

    public function testFindTopRatedMoviesCallsRepository(): void
    {
        $mockRepository = $this->createMock(MoviesRepositoryInterface::class);

        $page = 2;

        $expectedMovies = [
            ['id' => 1, 'title' => 'Sample Movie 1'],
            ['id' => 2, 'title' => 'Sample Movie 2'],
            ['id' => 3, 'title' => 'Sample Movie 3']
        ];
        $mockRepository->expects($this->once())
            ->method('findTopRatedMovies')
            ->with($page)
            ->willReturn($expectedMovies);

        $moviesService = new MoviesService($mockRepository);

        $result = $moviesService->findTopRatedMovies($page);

        $this->assertEquals($expectedMovies, $result);
    }

    public function testFindSimilarMoviesCallsRepository(): void
    {
        $mockRepository = $this->createMock(MoviesRepositoryInterface::class);

        $movieId = 123;

        $page = 2;

        $expectedMovies = [
            ['id' => 1, 'title' => 'Similar Movie 1'],
            ['id' => 2, 'title' => 'Similar Movie 2'],
            ['id' => 3, 'title' => 'Similar Movie 3']
        ];
        $mockRepository->expects($this->once())
            ->method('findSimilarMovies')
            ->with($movieId, $page)
            ->willReturn($expectedMovies);

        $moviesService = new MoviesService($mockRepository);

        $result = $moviesService->findSimilarMovies($movieId, $page);

        $this->assertEquals($expectedMovies, $result);
    }

    public function testSearchMoviesCallsRepository(): void
    {
        $mockRepository = $this->createMock(MoviesRepositoryInterface::class);

        $query = "action";

        $page = 2;

        $expectedMovies = [
            ['id' => 1, 'title' => 'Action Movie 1'],
            ['id' => 2, 'title' => 'Action Movie 2'],
            ['id' => 3, 'title' => 'Action Movie 3']
        ];
        $mockRepository->expects($this->once())
            ->method('searchMovies')
            ->with($query, $page)
            ->willReturn($expectedMovies);

        $moviesService = new MoviesService($mockRepository);

        $result = $moviesService->searchMovies($query, $page);

        $this->assertEquals($expectedMovies, $result);
    }


    public function testFindMoviesByGenreCallsRepository(): void
    {
        $mockRepository = $this->createMock(MoviesRepositoryInterface::class);

        $genreId = 1;

        $page = 2;

        $expectedMovies = [
            ['id' => 1, 'title' => 'Genre Movie 1'],
            ['id' => 2, 'title' => 'Genre Movie 2'],
            ['id' => 3, 'title' => 'Genre Movie 3']
        ];
        $mockRepository->expects($this->once())
            ->method('findMoviesByGenre')
            ->with($genreId, $page)
            ->willReturn($expectedMovies);

        $moviesService = new MoviesService($mockRepository);

        $result = $moviesService->findMoviesByGenre($genreId, $page);

        $this->assertEquals($expectedMovies, $result);
    }

    public function testFindAllGenresCallsRepository(): void
    {
        $mockRepository = $this->createMock(MoviesRepositoryInterface::class);

        $expectedGenres = [
            1 => 'Action',
            2 => 'Drama',
            3 => 'Comedy'
        ];
        $mockRepository->expects($this->once())
            ->method('findAllGenres')
            ->willReturn($expectedGenres);

        $moviesService = new MoviesService($mockRepository);

        $result = $moviesService->findAllGenres();

        $this->assertEquals($expectedGenres, $result);
    }

    public function testFindMovieByIdCallsRepository(): void
    {
        $mockRepository = $this->createMock(MoviesRepositoryInterface::class);

        $movieId = 123;

        $expectedMovie = new Movie(
            $movieId,
            "Test Movie",
            "This is a test movie",
            "2024-01-01",
            "/poster.jpg",
            [1, 2, 3]
        );

        $mockRepository->expects($this->once())
            ->method('findMovieById')
            ->with($movieId)
            ->willReturn($expectedMovie);

        $moviesService = new MoviesService($mockRepository);

        $result = $moviesService->findMovieById($movieId);

        $this->assertEquals($expectedMovie, $result);
    }

    public function testFindMoviesByTitleCallsRepository(): void
    {
        $mockRepository = $this->createMock(MoviesRepositoryInterface::class);

        $title = "Test Movie";

        $expectedMovies = [
            new Movie(
                1,
                "Test Movie 1",
                "This is a test movie 1",
                "2024-01-01",
                "/poster1.jpg",
                [1, 2, 3]
            ),
            new Movie(
                2,
                "Test Movie 2",
                "This is a test movie 2",
                "2024-02-01",
                "/poster2.jpg",
                [4, 5, 6]
            )
        ];

        $mockRepository->expects($this->once())
            ->method('findMoviesByTitle')
            ->with($title)
            ->willReturn($expectedMovies);

        $moviesService = new MoviesService($mockRepository);

        $result = $moviesService->findMoviesByTitle($title);

        $this->assertEquals($expectedMovies, $result);
    }
}
