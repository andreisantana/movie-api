<?php

namespace Application\Services;

use Domain\Model\Movie;
use Domain\Repository\MoviesRepositoryInterface;

class MoviesService
{
    private $moviesRepository;

    public function __construct(MoviesRepositoryInterface $moviesRepository)
    {
        $this->moviesRepository = $moviesRepository;
    }

    public function findById(int $id): ?Movie
    {
        return $this->moviesRepository->findById($id);
    }

    public function findByTitle(string $title): array
    {
        return $this->moviesRepository->findByTitle($title);
    }

    public function findUpcomingMovies(string $page = null): array
    {
        return $this->moviesRepository->findUpcomingMovies($page);
    }

    public function findTopRatedMovies(string $page = null): array
    {
        return $this->moviesRepository->findTopRatedMovies($page);
    }

    public function findSimilarMovies(int $movieId, string $page = null): array
    {
        return $this->moviesRepository->findSimilarMovies($movieId, $page);
    }

    public function searchMovies(string $query, int $page = 1): array
    {
        return $this->moviesRepository->searchMovies($query, $page);
    }

    public function findMoviesByGenre(int $genreId, int $page = 1): array
    {
        return $this->moviesRepository->findMoviesByGenre($genreId, $page);
    }

    public function findAllGenres(): array
    {
        return $this->moviesRepository->findAllGenres();
    }

    public function findMovieById(int $id): ?Movie
    {
        return $this->moviesRepository->findMovieById($id);
    }

    public function findMoviesByTitle(string $title): array
    {
        return $this->moviesRepository->findMoviesByTitle($title);
    }
}
