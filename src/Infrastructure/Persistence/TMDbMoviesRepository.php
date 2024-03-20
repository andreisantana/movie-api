<?php

namespace Infrastructure\Persistence;

use Domain\Model\Movie;
use Domain\Repository\MoviesRepositoryInterface;
use Infrastructure\HTTP\HttpClient;

class TMDbMoviesRepository implements MoviesRepositoryInterface
{
    private const BASE_URL = 'https://api.themoviedb.org/3/';
    private $apiKey;
    private $httpClient;

    public function __construct(string $apiKey, HttpClient $httpClient)
    {
        $this->apiKey = $apiKey;
        $this->httpClient = $httpClient;
    }

    public function findById(int $id): ?Movie
    {
        $url = self::BASE_URL . "movie/{$id}?api_key={$this->apiKey}";
        $response = $this->httpClient->get($url);

        if (!$response) {
            return null;
        }

        $movieData = json_decode($response, true);

        return $this->mapMovieDataToModel($movieData);
    }

    public function findSimilarMovies(int $id, string $page = null): array
    {
        $url = self::BASE_URL . "movie/{$id}/similar?api_key={$this->apiKey}{$page}";
        $response = $this->httpClient->get($url);

        if (!$response) {
            return ['error' => 'Movies not found'];
        }

        $similarMoviesData = json_decode($response, true)['results'];
        $similarMovies = [];

        foreach ($similarMoviesData as $movieData) {
            $similarMovie = [
                'id' => $movieData['id'],
                'title' => $movieData['title'],
                'overview' => $movieData['overview'],
                'release_date' => $movieData['release_date'],
                'vote_average' => $movieData['vote_average'],
                'adult' => $movieData['adult'],
                'backdrop_path' => $movieData['backdrop_path'],
                'genre_ids' => $movieData['genre_ids'],
                'original_language' => $movieData['original_language'],
                'original_title' => $movieData['original_title'],
                'popularity' => $movieData['popularity'],
                'poster_path' => $movieData['poster_path'],
                'video' => $movieData['video'],
                'vote_count' => $movieData['vote_count']
            ];

            $similarMovies[] = $similarMovie;
        }

        return $similarMovies;
    }


    public function findByTitle(string $title): array
    {
        $url = self::BASE_URL . "search/movie?api_key={$this->apiKey}&query=" . urlencode($title);
        $response = $this->httpClient->get($url);

        if (!$response) {
            return [];
        }

        $moviesData = json_decode($response, true)['results'];
        $movies = [];

        foreach ($moviesData as $movieData) {
            $movies[] = $this->mapMovieDataToModel($movieData);
        }

        return $movies;
    }


    public function findTopRatedMovies(string $page): array
    {
        $url = self::BASE_URL . "movie/top_rated?api_key={$this->apiKey}{$page}";
        $response = $this->httpClient->get($url);

        if (!$response) {
            return [];
        }

        $topRatedMoviesData = json_decode($response, true)['results'];
        $topRatedMovies = [];

        foreach ($topRatedMoviesData as $movieData) {
            $movie = [
                'id' => $movieData['id'],
                'title' => $movieData['title'],
                'overview' => $movieData['overview'],
                'release_date' => $movieData['release_date'],
                'vote_average' => $movieData['vote_average'],
                'adult' => $movieData['adult'],
                'backdrop_path' => $movieData['backdrop_path'],
                'genre_ids' => $movieData['genre_ids'],
                'original_language' => $movieData['original_language'],
                'original_title' => $movieData['original_title'],
                'popularity' => $movieData['popularity'],
                'poster_path' => $movieData['poster_path'],
                'video' => $movieData['video'],
                'vote_count' => $movieData['vote_count'],
            ];

            $topRatedMovies[] = $movie;
        }

        return $topRatedMovies;
    }



    public function findUpcomingMovies(string $page): array
    {
        $url = self::BASE_URL . "movie/upcoming?api_key={$this->apiKey}{$page}";
        $response = $this->httpClient->get($url);

        if (!$response) {
            return ['error' => 'Movies not found'];
        }

        $upcomingMoviesData = json_decode($response, true)['results'];
        $upcomingMovies = [];

        foreach ($upcomingMoviesData as $movieData) {
            $upcomingMovie = [
                'id' => $movieData['id'],
                'title' => $movieData['title'],
                'overview' => $movieData['overview'],
                'release_date' => $movieData['release_date'],
                'vote_average' => $movieData['vote_average'],
                'adult' => $movieData['adult'],
                'backdrop_path' => $movieData['backdrop_path'],
                'genre_ids' => $movieData['genre_ids'],
                'original_language' => $movieData['original_language'],
                'original_title' => $movieData['original_title'],
                'popularity' => $movieData['popularity'],
                'poster_path' => $movieData['poster_path'],
                'video' => $movieData['video'],
                'vote_count' => $movieData['vote_count']
            ];

            $upcomingMovies[] = $upcomingMovie;
        }

        return $upcomingMovies;
    }



    public function searchMovies(string $keyword): array
    {
        $url = self::BASE_URL . "search/movie?api_key={$this->apiKey}&query={$keyword}";
        $response = $this->httpClient->get($url);

        if (!$response) {
            return [];
        }

        $moviesData = json_decode($response, true)['results'];
        $movies = [];

        foreach ($moviesData as $movieData) {
            $movies[] = $this->mapMovieDataToModel($movieData);
        }

        return $movies;
    }


    public function findMoviesByGenre(int $genreId): array
    {
        $url = self::BASE_URL . "discover/movie?api_key={$this->apiKey}&with_genres={$genreId}";
        $response = $this->httpClient->get($url);

        if (!$response) {
            return [];
        }

        $moviesData = json_decode($response, true)['results'];
        $movies = [];

        foreach ($moviesData as $movieData) {
            $movies[] = $this->mapMovieDataToModel($movieData);
        }

        return $movies;
    }


    public function findMovieById(int $id): ?Movie
    {
        return $this->findById($id);
    }

    public function findAllGenres(): array
    {
        $url = self::BASE_URL . "genre/movie/list?api_key={$this->apiKey}";
        $response = $this->httpClient->get($url);

        if (!$response) {
            return [];
        }

        $genresData = json_decode($response, true)['genres'];
        $genres = [];

        foreach ($genresData as $genreData) {
            $genres[$genreData['id']] = $genreData['name'];
        }

        return $genres;
    }

    public function findMoviesByTitle(string $title): array
    {
        $url = self::BASE_URL . "search/movie?api_key={$this->apiKey}&query={$title}";
        $response = $this->httpClient->get($url);

        if (!$response) {
            return [];
        }

        $moviesData = json_decode($response, true)['results'];
        $movies = [];

        foreach ($moviesData as $movieData) {
            $movies[] = $this->mapMovieDataToModel($movieData);
        }

        return $movies;
    }


    private function mapMovieDataToModel(array $movieData): Movie
    {

        $genres = isset($movieData['genres']) ? $movieData['genres'] : $movieData['genre_ids'];

        return new Movie(
            $movieData['id'],
            $movieData['original_title'],
            $movieData['overview'],
            $movieData['release_date'],
            $movieData['poster_path'],
            $genres
        );
    }
}
