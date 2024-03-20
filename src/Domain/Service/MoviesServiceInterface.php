<?php

namespace Domain\Service;

use Domain\Model\Movie;

interface MoviesServiceInterface
{
    /**
     * Finds a movie by its ID.
     *
     * @param int $id The ID of the movie to find.
     * @return Movie|null The found Movie object or null if not found.
     */
    public function findMovieById(int $id): ?Movie;

    /**
     * Finds movies by title.
     *
     * @param string $title The title of the movie to search for.
     * @return array A list of found Movie objects.
     */
    public function findMoviesByTitle(string $title): array;

    /**
     * Returns all movies.
     *
     * @return array A list of Movie objects.
     */
    public function findAllMovies(): array;

    /**
     * Saves a new movie.
     *
     * @param array $movieData The data of the movie to be saved.
     * @return Movie|null The saved Movie object or null in case of error.
     */
    public function saveMovie(array $movieData): ?Movie;

    /**
     * Updates an existing movie.
     *
     * @param int $id The ID of the movie to be updated.
     * @param array $movieData The new data of the movie.
     * @return Movie|null The updated Movie object or null in case of error.
     */
    public function updateMovie(int $id, array $movieData): ?Movie;

    /**
     * Deletes a movie.
     *
     * @param int $id The ID of the movie to be deleted.
     * @return bool True if the movie was successfully deleted, false otherwise.
     */
    public function deleteMovie(int $id): bool;
}
