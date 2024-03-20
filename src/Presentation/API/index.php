<?php

use Application\Controllers\MoviesController;
use Application\Services\MoviesService;
use Infrastructure\Persistence\TMDbMoviesRepository;
use Infrastructure\HTTP\HttpClient;
use Dotenv\Dotenv;

require_once __DIR__ . '/../../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

$httpClient = new HttpClient();
$apiKey = $_ENV['TMDB_API_KEY'];

$moviesRepository = new TMDbMoviesRepository($apiKey, $httpClient);
$moviesService = new MoviesService($moviesRepository);
$moviesController = new MoviesController($moviesService);

$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestUri = $_SERVER['REQUEST_URI'];
$requestUri = strtok($requestUri, '?');

$page = isset($_GET['page']) ? (int)$_GET['page'] : null;

switch ($requestMethod) {
    case 'GET':
        // Endpoint /upcoming
        if (preg_match('/\/upcoming/', $requestUri)) {
            handleRequest('upcoming', null, $page);
        }
        // Endpoint /top_rated
        elseif (preg_match('/\/top_rated/', $requestUri)) {
            handleRequest('top_rated', null, $page);
        }
        // Endpoint /movies/{id}/similar
        elseif (preg_match('/\/movies\/(\d+)\/similar/', $requestUri, $matches)) {
            $movieId = (int) $matches[1];
            handleRequest('similar_movies', $movieId, $page);
        }
        // Endpoint /movies/{id}
        elseif (preg_match('/\/movies\/(\d+)/', $requestUri, $matches)) {
            $movieId = (int) $matches[1];
            handleRequest('movie_by_id', $movieId);
        }
        // Endpoint /movies
        elseif (preg_match('/\/genres/', $requestUri)) {
            handleRequest('genres');
        }
        // Endpoint /search?q={query}
        elseif (preg_match('/\/search/', $requestUri)) {
            $query = isset($_GET['movie']) ? (string)$_GET['movie'] : null;
            handleRequest('search_movies', $query);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Route not found']);
        }
        break;
    default:
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
}


function handleRequest($endpoint, $param = null, $page = null)
{
    $pageParam = ($page !== null) ? "&page={$page}" : '';

    global $moviesController;
    switch ($endpoint) {
        case 'upcoming':
            echo $moviesController->handleUpcomingMoviesRequest($pageParam);
            break;
        case 'top_rated':
            echo $moviesController->handleTopRatedMoviesRequest($pageParam);
            break;
        case 'genres':
            echo $moviesController->handleGenresRequest();
            break;
        case 'movie_by_id':
            echo $moviesController->handleMovieByIdRequest($param);
            break;
        case 'similar_movies':
            echo $moviesController->handleSimilarMoviesRequest($param, $pageParam);
            break;
        case 'search_movies':
            echo $moviesController->handleSearchMoviesRequest($param);
            break;
        default:
            http_response_code(404);
            echo json_encode(['error' => 'Endpoint not found']);
    }
}
