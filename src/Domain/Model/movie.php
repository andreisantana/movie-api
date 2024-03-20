<?php

namespace Domain\Model;

class Movie
{
    private $id;
    private $title;
    private $overview;
    private $releaseDate;
    private $posterPath;
    private $genreIds;

    public function __construct(
        int $id,
        string $title,
        string $overview,
        string $releaseDate,
        string $posterPath,
        array $genreIds
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->overview = $overview;
        $this->releaseDate = $releaseDate;
        $this->posterPath = $posterPath;
        $this->genreIds = $genreIds;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getOverview(): string
    {
        return $this->overview;
    }

    public function getReleaseDate(): string
    {
        return $this->releaseDate;
    }

    public function getPosterPath(): string
    {
        return $this->posterPath;
    }

    public function getGenreIds(): array
    {
        return $this->genreIds;
    }

     public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'overview' => $this->overview,
            'releaseDate' => $this->releaseDate,
            'posterPath' => $this->posterPath,
            'genreIds' => $this->genreIds,
        ];
    }
}
