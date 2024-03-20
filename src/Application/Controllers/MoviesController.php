<?php

namespace Application\Controllers;

use Application\Services\MoviesService;

class MoviesController
{
    private $moviesService;

    public function __construct(MoviesService $moviesService)
    {
        $this->moviesService = $moviesService;
    }

    public function getMovieById(int $id): array
    {
        try {
            $movie = $this->moviesService->findMovieById($id);

            if ($movie === null) {
                http_response_code(404);
                return ['error' => 'Movie not found'];
            }

            return $movie->toArray();
        } catch (\Exception $e) {
            http_response_code(500);
            return ['error' => $e->getMessage()];
        }
    }

    public function searchMoviesByTitle(string $title): array
    {
        try {
            $movies = $this->moviesService->findMoviesByTitle($title);
            return $movies;
        } catch (\Exception $e) {
            http_response_code(500);
            return ['error' => $e->getMessage()];
        }
    }

    public function getUpcomingMovies(string $page = null): array
    {
        try {
            $movies = $this->moviesService->findUpcomingMovies($page);
            return $movies;
        } catch (\Exception $e) {
            http_response_code(500);
            return ['error' => $e->getMessage()];
        }
    }

    public function getTopRatedMovies(string $page = null): array
    {
        try {
            $movies = $this->moviesService->findTopRatedMovies($page);
            return $movies;
        } catch (\Exception $e) {
            http_response_code(500);
            return ['error' => $e->getMessage()];
        }
    }

    public function getSimilarMovies(int $movieId, string $page = null): array
    {
        try {
            $movies = $this->moviesService->findSimilarMovies($movieId, $page);
            return $movies;
        } catch (\Exception $e) {
            http_response_code(500);
            return ['error' => $e->getMessage()];
        }
    }

    public function getGenres(): array
    {
        try {
            $genres = $this->moviesService->findAllGenres();
            return $genres;
        } catch (\Exception $e) {
            http_response_code(500);
            return ['error' => $e->getMessage()];
        }
    }

    public function searchMovies(string $query): array
    {
        try {
            $movies = $this->moviesService->searchMovies($query);
            $jsonMovies = [];
            foreach ($movies as $movie) {
                $jsonMovies[] = [
                    'id' => $movie->getId(),
                    'title' => $movie->getTitle(),
                    'overview' => $movie->getOverview(),
                    'releaseDate' => $movie->getReleaseDate(),
                    'posterPath' => $movie->getPosterPath(),
                    'genreIds' => $movie->getGenreIds(),
                ];
            }
            return $jsonMovies;
        } catch (\Exception $e) {
            http_response_code(500);
            return ['error' => $e->getMessage()];
        }
    }

    public function handleUpcomingMoviesRequest(string $page = null): string
    {
        header('Content-Type: application/json');
        return json_encode($this->getUpcomingMovies($page));
    }

    public function handleTopRatedMoviesRequest($page): string
    {
        header('Content-Type: application/json');
        return json_encode($this->getTopRatedMovies($page));
    }

    public function handleMovieByIdRequest(int $movieId): string
    {
        header('Content-Type: application/json');
        return json_encode($this->getMovieById($movieId));
    }

    public function handleSimilarMoviesRequest(int $movieId, string $page): string
    {
        header('Content-Type: application/json');
        return json_encode($this->getSimilarMovies($movieId, $page));
    }

    public function handleGenresRequest(): string
    {
        header('Content-Type: application/json');
        return json_encode($this->getGenres());
    }

    public function handleSearchMoviesRequest(string $query): string
    {
        header('Content-Type: application/json');
        return json_encode($this->searchMovies($query));
    }
}
