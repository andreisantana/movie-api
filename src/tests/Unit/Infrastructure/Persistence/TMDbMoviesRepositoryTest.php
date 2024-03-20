<?php

namespace Tests\Unit\Infrastructure\Persistence;

use Infrastructure\Persistence\TMDbMoviesRepository;
use Infrastructure\HTTP\HttpClient;
use PHPUnit\Framework\TestCase;
use Domain\Model\Movie;

class TMDbMoviesRepositoryTest extends TestCase
{
    public function testFindByIdReturnsMovieIfExists(): void
    {
        $mockHttpClient = $this->createMock(HttpClient::class);

        $movieId = 123;

        $expectedResponse = '{"id":123,"original_title":"Movie Title","overview":"Movie Overview","release_date":"2022-01-01","poster_path":"/path/to/poster","genres":[1,2]}';
        $mockHttpClient->expects($this->once())
            ->method('get')
            ->willReturn($expectedResponse);

        $repository = new TMDbMoviesRepository('fake_api_key', $mockHttpClient);

        $result = $repository->findById($movieId);

        $this->assertInstanceOf(Movie::class, $result);

        $this->assertEquals(123, $result->getId());
        $this->assertEquals('Movie Title', $result->getTitle());
        $this->assertEquals('Movie Overview', $result->getOverview());
        $this->assertEquals('2022-01-01', $result->getReleaseDate());
        $this->assertEquals('/path/to/poster', $result->getPosterPath());
        $this->assertEquals([1, 2], $result->getGenreIds());
    }

    public function testFindByIdReturnsNullIfMovieDoesNotExist(): void
    {
        $mockHttpClient = $this->createMock(HttpClient::class);

        $movieId = 456;

        $mockHttpClient->expects($this->once())
            ->method('get')
            ->willReturn(null);

        $repository = new TMDbMoviesRepository('fake_api_key', $mockHttpClient);

        $result = $repository->findById($movieId);

        $this->assertNull($result);
    }


    public function testFindSimilarMoviesReturnsSimilarMovies()
    {
        $httpClientMock = $this->createMock(HttpClient::class);
        $httpClientMock->method('get')->willReturn('{"results": []}');

        $repository = new TMDbMoviesRepository('API_KEY', $httpClientMock);

        $result = $repository->findSimilarMovies(123);

        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

    public function testFindSimilarMoviesReturnsEmptyArrayOnApiFailure()
    {
        $httpClientMock = $this->createMock(HttpClient::class);
        $httpClientMock->method('get')->willReturn('{"results": []}');

        $repository = new TMDbMoviesRepository('API_KEY', $httpClientMock);

        $result = $repository->findSimilarMovies(123);

        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }


    public function testFindTopRatedMoviesReturnsTopRatedMovies(): void
    {
        $mockHttpClient = $this->createMock(HttpClient::class);

        $expectedResponse = '{"results": [
            {"id": 1, "title": "Top Rated Movie 1", "overview": "Overview 1", "release_date": "2022-01-01", "vote_average": 8.5, "adult": false, "backdrop_path": "/path/to/backdrop1", "genre_ids": [1, 2], "original_language": "en", "original_title": "Original Title 1", "popularity": 100.0, "poster_path": "/path/to/poster1", "video": false, "vote_count": 1000},
            {"id": 2, "title": "Top Rated Movie 2", "overview": "Overview 2", "release_date": "2022-01-02", "vote_average": 8.0, "adult": false, "backdrop_path": "/path/to/backdrop2", "genre_ids": [3, 4], "original_language": "en", "original_title": "Original Title 2", "popularity": 90.0, "poster_path": "/path/to/poster2", "video": false, "vote_count": 900}
        ]}';
        $mockHttpClient->expects($this->once())
            ->method('get')
            ->willReturn($expectedResponse);

        $repository = new TMDbMoviesRepository('fake_api_key', $mockHttpClient);

        $topRatedMovies = $repository->findTopRatedMovies(10);

        $this->assertCount(2, $topRatedMovies);

        $this->assertEquals(1, $topRatedMovies[0]['id']);
        $this->assertEquals('Top Rated Movie 1', $topRatedMovies[0]['title']);
        $this->assertEquals('Overview 1', $topRatedMovies[0]['overview']);
        $this->assertEquals('2022-01-01', $topRatedMovies[0]['release_date']);
        $this->assertEquals(8.5, $topRatedMovies[0]['vote_average']);
        $this->assertFalse($topRatedMovies[0]['adult']);
        $this->assertEquals('/path/to/backdrop1', $topRatedMovies[0]['backdrop_path']);
        $this->assertEquals([1, 2], $topRatedMovies[0]['genre_ids']);
        $this->assertEquals('en', $topRatedMovies[0]['original_language']);
        $this->assertEquals('Original Title 1', $topRatedMovies[0]['original_title']);
        $this->assertEquals(100.0, $topRatedMovies[0]['popularity']);
        $this->assertEquals('/path/to/poster1', $topRatedMovies[0]['poster_path']);
        $this->assertFalse($topRatedMovies[0]['video']);
        $this->assertEquals(1000, $topRatedMovies[0]['vote_count']);

        $this->assertEquals(2, $topRatedMovies[1]['id']);
        $this->assertEquals('Top Rated Movie 2', $topRatedMovies[1]['title']);
        $this->assertEquals('Overview 2', $topRatedMovies[1]['overview']);
        $this->assertEquals('2022-01-02', $topRatedMovies[1]['release_date']);
        $this->assertEquals(8.0, $topRatedMovies[1]['vote_average']);
        $this->assertFalse($topRatedMovies[1]['adult']);
        $this->assertEquals('/path/to/backdrop2', $topRatedMovies[1]['backdrop_path']);
        $this->assertEquals([3, 4], $topRatedMovies[1]['genre_ids']);
        $this->assertEquals('en', $topRatedMovies[1]['original_language']);
        $this->assertEquals('Original Title 2', $topRatedMovies[1]['original_title']);
        $this->assertEquals(90.0, $topRatedMovies[1]['popularity']);
        $this->assertEquals('/path/to/poster2', $topRatedMovies[1]['poster_path']);
        $this->assertFalse($topRatedMovies[1]['video']);
        $this->assertEquals(900, $topRatedMovies[1]['vote_count']);
    }

    public function testFindUpcomingMoviesReturnsUpcomingMovies()
    {
        $httpClientMock = $this->createMock(HttpClient::class);
        $httpClientMock->method('get')->willReturn('{"results": []}');

        $repository = new TMDbMoviesRepository('API_KEY', $httpClientMock);

        $result = $repository->findUpcomingMovies(1);

        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

    public function testSearchMoviesReturnsMoviesWithAllAttributes(): void
    {
        $mockHttpClient = $this->createMock(HttpClient::class);

        $keyword = 'avatar';

        $expectedResponse = '{"results": [
        {"id": 1, "original_title": "Avatar", "overview": "Overview 1", "release_date": "2009-12-18", "poster_path": "/path/to/poster1", "genres": [1, 2]},
        {"id": 2, "original_title": "Avatar: The Last Airbender", "overview": "Overview 2", "release_date": "2005-02-21", "poster_path": "/path/to/poster2", "genres": [3, 4]}
    ]}';
        $mockHttpClient->expects($this->once())
            ->method('get')
            ->willReturn($expectedResponse);

        $repository = new TMDbMoviesRepository('fake_api_key', $mockHttpClient);

        $searchResult = $repository->searchMovies($keyword);

        $this->assertCount(2, $searchResult);

        $this->assertEquals(1, $searchResult[0]->getId());
        $this->assertEquals('Avatar', $searchResult[0]->getTitle());
        $this->assertEquals('Overview 1', $searchResult[0]->getOverview());
        $this->assertEquals('2009-12-18', $searchResult[0]->getReleaseDate());
        $this->assertEquals('/path/to/poster1', $searchResult[0]->getPosterPath());
        $this->assertEquals([1, 2], $searchResult[0]->getGenreIds());

        $this->assertEquals(2, $searchResult[1]->getId());
        $this->assertEquals('Avatar: The Last Airbender', $searchResult[1]->getTitle());
        $this->assertEquals('Overview 2', $searchResult[1]->getOverview());
        $this->assertEquals('2005-02-21', $searchResult[1]->getReleaseDate());
        $this->assertEquals('/path/to/poster2', $searchResult[1]->getPosterPath());
        $this->assertEquals([3, 4], $searchResult[1]->getGenreIds());
    }

    public function testFindMoviesByGenreReturnsMovies(): void
    {
        $mockHttpClient = $this->createMock(HttpClient::class);

        $genreId = 28;

        $expectedResponse = '{"results": [
        {"id": 1, "original_title": "Movie 1", "overview": "Overview 1", "release_date": "2022-01-01", "poster_path": "/path/to/poster1", "genres": [28]},
        {"id": 2, "original_title": "Movie 2", "overview": "Overview 2", "release_date": "2022-01-02", "poster_path": "/path/to/poster2", "genres": [28]},
        {"id": 3, "original_title": "Movie 3", "overview": "Overview 3", "release_date": "2022-01-03", "poster_path": "/path/to/poster3", "genres": [28]}
    ]}';
        $mockHttpClient->expects($this->once())
            ->method('get')
            ->willReturn($expectedResponse);

        $repository = new TMDbMoviesRepository('fake_api_key', $mockHttpClient);

        $moviesByGenre = $repository->findMoviesByGenre($genreId);

        $this->assertCount(3, $moviesByGenre);

        $this->assertEquals(1, $moviesByGenre[0]->getId());
        $this->assertEquals('Movie 1', $moviesByGenre[0]->getTitle());
        $this->assertEquals('Overview 1', $moviesByGenre[0]->getOverview());
        $this->assertEquals('2022-01-01', $moviesByGenre[0]->getReleaseDate());
        $this->assertEquals('/path/to/poster1', $moviesByGenre[0]->getPosterPath());
        $this->assertEquals([28], $moviesByGenre[0]->getGenreIds());

        $this->assertEquals(2, $moviesByGenre[1]->getId());
        $this->assertEquals('Movie 2', $moviesByGenre[1]->getTitle());
        $this->assertEquals('Overview 2', $moviesByGenre[1]->getOverview());
        $this->assertEquals('2022-01-02', $moviesByGenre[1]->getReleaseDate());
        $this->assertEquals('/path/to/poster2', $moviesByGenre[1]->getPosterPath());
        $this->assertEquals([28], $moviesByGenre[1]->getGenreIds());

        $this->assertEquals(3, $moviesByGenre[2]->getId());
        $this->assertEquals('Movie 3', $moviesByGenre[2]->getTitle());
        $this->assertEquals('Overview 3', $moviesByGenre[2]->getOverview());
        $this->assertEquals('2022-01-03', $moviesByGenre[2]->getReleaseDate());
        $this->assertEquals('/path/to/poster3', $moviesByGenre[2]->getPosterPath());
        $this->assertEquals([28], $moviesByGenre[2]->getGenreIds());
    }

    public function testFindMovieByIdReturnsMovieIfExists(): void
    {
        $mockHttpClient = $this->createMock(HttpClient::class);

        $movieId = 123;

        $expectedResponse = '{"id":123,"original_title":"Movie Title","overview":"Movie Overview","release_date":"2022-01-01","poster_path":"/path/to/poster","genres":[1,2]}';
        $mockHttpClient->expects($this->once())
            ->method('get')
            ->willReturn($expectedResponse);

        $repository = new TMDbMoviesRepository('fake_api_key', $mockHttpClient);

        $foundMovie = $repository->findMovieById($movieId);

        $this->assertInstanceOf(Movie::class, $foundMovie);
        $this->assertEquals(123, $foundMovie->getId());
        $this->assertEquals('Movie Title', $foundMovie->getTitle());
        $this->assertEquals('Movie Overview', $foundMovie->getOverview());
        $this->assertEquals('2022-01-01', $foundMovie->getReleaseDate());
        $this->assertEquals('/path/to/poster', $foundMovie->getPosterPath());
        $this->assertEquals([1, 2], $foundMovie->getGenreIds());
    }

    public function testFindMovieByIdReturnsNullIfMovieDoesNotExist(): void
    {
        $mockHttpClient = $this->createMock(HttpClient::class);

        $movieId = 456;

        $mockHttpClient->expects($this->once())
            ->method('get')
            ->willReturn(null);

        $repository = new TMDbMoviesRepository('fake_api_key', $mockHttpClient);

        $notFoundMovie = $repository->findMovieById($movieId);

        $this->assertNull($notFoundMovie);
    }


    public function testFindAllGenres(): void
    {
        $mockHttpClient = $this->createMock(HttpClient::class);

        $expectedResponse = '{"genres": [
            {"id": 28, "name": "Action"},
            {"id": 12, "name": "Adventure"},
            {"id": 16, "name": "Animation"}
        ]}';
        $mockHttpClient->expects($this->once())
            ->method('get')
            ->willReturn($expectedResponse);

        $repository = new TMDbMoviesRepository('fake_api_key', $mockHttpClient);

        $genres = $repository->findAllGenres();

        $this->assertIsArray($genres);
        $this->assertCount(3, $genres);
        $this->assertEquals('Action', $genres[28]);
        $this->assertEquals('Adventure', $genres[12]);
        $this->assertEquals('Animation', $genres[16]);
    }

    public function testFindMoviesByTitle(): void
    {
        $mockHttpClient = $this->createMock(HttpClient::class);

        $title = 'avatar';

        $expectedResponse = '{"results": [
        {"id": 1, "original_title": "Avatar", "overview": "Overview 1", "release_date": "2009-12-18", "poster_path": "/path/to/poster1", "genres": [1, 2]},
        {"id": 2, "original_title": "Avatar: The Last Airbender", "overview": "Overview 2", "release_date": "2005-02-21", "poster_path": "/path/to/poster2", "genres": [3, 4]}
    ]}';
        $mockHttpClient->expects($this->once())
            ->method('get')
            ->willReturn($expectedResponse);

        $repository = new TMDbMoviesRepository('fake_api_key', $mockHttpClient);

        $searchResult = $repository->findMoviesByTitle($title);

        $this->assertCount(2, $searchResult);

        $this->assertEquals(1, $searchResult[0]->getId());
        $this->assertEquals('Avatar', $searchResult[0]->getTitle());
        $this->assertEquals('Overview 1', $searchResult[0]->getOverview());
        $this->assertEquals('2009-12-18', $searchResult[0]->getReleaseDate());
        $this->assertEquals('/path/to/poster1', $searchResult[0]->getPosterPath());
        $this->assertEquals([1, 2], $searchResult[0]->getGenreIds());

        $this->assertEquals(2, $searchResult[1]->getId());
        $this->assertEquals('Avatar: The Last Airbender', $searchResult[1]->getTitle());
        $this->assertEquals('Overview 2', $searchResult[1]->getOverview());
        $this->assertEquals('2005-02-21', $searchResult[1]->getReleaseDate());
        $this->assertEquals('/path/to/poster2', $searchResult[1]->getPosterPath());
        $this->assertEquals([3, 4], $searchResult[1]->getGenreIds());
    }
}
