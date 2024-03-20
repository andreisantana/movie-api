<?php

namespace Domain\Repository;

use Domain\Model\Movie;

interface MoviesRepositoryInterface
{
    /**
     * Finds a movie by its ID.
     *
     * @param int $id The ID of the movie to find.
     * @return Movie|null The found Movie object or null if not found.
     */
    public function findById(int $id): ?Movie;

    /**
     * Finds movies by title.
     *
     * @param string $title The title of the movie to search for.
     * @return array A list of found Movie objects.
     */
    public function findByTitle(string $title): array;

    /**
     * Finds movies that are similar to a specific movie.
     *
     * @param int $id The ID of the movie for which similar ones will be searched.
     * @param string $page The page number.
     * @return array A list of similar Movie objects.
     */
    public function findSimilarMovies(int $id, string $page): array;

    /**
     * Finds the top rated movies.
     *
     * @param string $page The page number.
     * @return array A list of top rated Movie objects.
     */
    public function findTopRatedMovies(string $page): array;

    /**
     * Finds upcoming movies.
     *
     * @param string $page The page number.
     * @return array A list of upcoming Movie objects.
     */
    public function findUpcomingMovies(string $page): array;

    /**
     * Searches movies by a certain keyword.
     *
     * @param string $keyword The keyword to search for.
     * @return array A list of Movie objects that match the keyword.
     */
    public function searchMovies(string $keyword): array;

    /**
     * Finds movies by genre.
     *
     * @param int $genreId The ID of the genre to search for.
     * @return array A list of Movie objects belonging to the specified genre.
     */
    public function findMoviesByGenre(int $genreId): array;

    /**
     * Finds a movie by its ID.
     *
     * @param int $id The ID of the movie to find.
     * @return Movie|null The found Movie object or null if not found.
     */
    public function findMovieById(int $id): ?Movie;

    /**
     * Returns all available movie genres.
     *
     * @return array A list of movie genres.
     */
    public function findAllGenres(): array;

    /**
     * Finds movies by title.
     *
     * @param string $title The title of the movie to search for.
     * @return array A list of found Movie objects.
     */
    public function findMoviesByTitle(string $title): array;
}
