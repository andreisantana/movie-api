<?php

namespace Tests\Integration\Controller;

use Domain\Model\Movie;
use Infrastructure\Persistence\TMDbMoviesRepository;
use Infrastructure\HTTP\HttpClient;
use PHPUnit\Framework\TestCase;
use Dotenv\Dotenv;

class MoviesControllerTest extends TestCase
{

    private const MOVIE_ID = 550;

    private $apiKey;
    private $baseUrl;
    private $repository;
    private $httpClientMock;

    protected function setUp(): void
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../..');
        $dotenv->load();

        $this->apiKey = $_ENV['TMDB_API_KEY'];
        $this->baseUrl = $_ENV['TMDB_API_URL'];
        $this->httpClientMock = $this->createMock(HttpClient::class);

        $this->repository = new TMDbMoviesRepository($this->apiKey, $this->httpClientMock);
    }

    public function testFindByIdReturnsMovie(): void
    {
        $response = json_encode([
            'id' => self::MOVIE_ID,
            'original_title' => 'The Dark Knight',
            'overview' => 'Batman fights crime in Gotham City.',
            'release_date' => '2008-07-18',
            'poster_path' => '/qJ2tW6WMUDux911r6m7haRef0WH.jpg',
            'genres' => ['Action', 'Crime', 'Drama']
        ]);
        $expectedUrl = "{$this->baseUrl}movie/" . self::MOVIE_ID . "?api_key={$this->apiKey}";
        $this->httpClientMock->expects($this->once())
            ->method('get')
            ->with($expectedUrl)
            ->willReturn($response);

        $movie = $this->repository->findMovieById(self::MOVIE_ID);

        $this->assertInstanceOf(Movie::class, $movie);
        $this->assertEquals(self::MOVIE_ID, $movie->getId());
        $this->assertEquals('The Dark Knight', $movie->getTitle());
        $this->assertEquals('Batman fights crime in Gotham City.', $movie->getOverview());
        $this->assertEquals('2008-07-18', $movie->getReleaseDate());
        $this->assertEquals('/qJ2tW6WMUDux911r6m7haRef0WH.jpg', $movie->getPosterPath());
        $this->assertEquals(['Action', 'Crime', 'Drama'], $movie->getGenreIds()); // Corrigido para getGenreIds()
    }


    public function testFindByIdReturnsNullForInvalidId(): void
    {
        $this->httpClientMock->expects($this->once())
            ->method('get')
            ->willReturn(null);

        $movie = $this->repository->findMovieById(9999);
        $this->assertNull($movie);
    }
}
