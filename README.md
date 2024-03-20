# Movie API

This project was initially developed as part of a technical challenge for a PHP developer opportunity. The challenge required using pure PHP to integrate with the themoviedb API, returning some predefined endpoints. The initial project was done in PHP 7+, with object-oriented programming, but without any design pattern, robust structure, and also lacked unit tests. Due to this, I decided to refactor the entire project and make it publicly available on GitHub to showcase my technical skills.

In this new version, I am using PHP 8+, PHPUnit, and other essential technologies for development. The project structure has been reorganized to follow best practices in architecture and software design, including the use of Clean Architecture and Clean Code principles.

## Project Structure

```
project/
│
├── docker/
│   ├── nginx/
│   │   └── default.conf
│   ├── xdebug/
│   │   └── xdebug.ini
│   ├── script/
│   │   └── entrypoint.sh
│   ├── docker-compose.yml
│   └── Dockerfile
│
├── src/
│   ├── application/
│   │   ├── controllers/
│   │   │   └── moviesController.php
│   │   └── services/
│   │       └── moviesService.php
│   ├── domain/
│   │   ├── model/
│   │   │   └── movie.php
│   │   ├── repository/
│   │   │   └── moviesRepositoryInterface.php
│   │   └── service/
│   │       └── moviesServiceInterface.php
│   ├── infrastructure/
│   │   ├── HTTP/
│   │   │   └── httpClient.php
│   │   └── persistence/
│   │       └── TMDBMoviesRepository.php
│   ├── presentation/
│   │   └── API/
│   │       └── index.php
│   ├── tests/
│   │   ├── integration/
│   │   │   ├── API/
│   │   │   │   └── httpClienttest.php
│   │   │   ├── Controller/
│   │   │   │   └── moviesControllerTest.php
│   │   │   ├── EndToEnd/
│   │   │   │   └── moviesEndToEndTest.php
│   │   │   └── service/
│   │   │       └── moviesServiceTest.php
│   │   └── unit/
│   │       ├── application/
│   │       │   └── services/
│   │       │       └── moviesServiceTest.php
│   │       ├── domain/
│   │       │   ├── model/
│   │       │   │   └── movieTest.php
│   │       │   ├── repository/
│   │       │   │   └── moviesRepositoryInterfaceTest.php
│   │       │   └── service/
│   │       │       └── moviesServiceInterfaceTest.php
│   │       └── infrastructure/
│   │           └── persistence/
│   │               └── TMDBMoviesRepositoryTest.php
│   │
│   ├── .env
│   ├── composer.json
│   ├── composer.lock
│   └── phpunit.xml
│
├── .gitignore
└── README.md
```

## Running the Project

To run the project, Docker must be installed on your machine. Then follow the steps below:

1. Clone the GitHub repository:

```
git clone https://github.com/andreisantana/movie-api.git
```

2. Navigate to the project directory:

```
cd movie-api
```

3. Rename the `.dev.env` file to `.env` and insert your themoviedb API Key.

4. Run the Docker Compose command to start the containers:

```
docker-compose up -d
```

Now you can access the API via `http://localhost:8000`.

## Endpoints

- `/top_rated`
- `/top_rated?page={page_number}`
- `/movies/{movie_id}`
- `/movies/{movie_id}/similar`
- `/movies/{movie_id}/similar?page={page_number}`
- `/search?movie={movie_name}`
- `/genres`

## Tests

The project includes automated tests to ensure code quality. Tests are divided into two main categories: unit tests and integration tests. They are located in the `tests/` directory. To run the tests, you can use PHPUnit. Just execute the following command in the root of the project:

```
docker-compose run php-test vendor/bin/phpunit
```

## Architecture

The project architecture follows the principles of Clean Architecture, which promotes separation of concerns and independence from frameworks. This allows the code to be more flexible and testable. Additionally, the project also follows the principles of Clean Code, emphasizing code readability, maintainability, and efficiency.

## Best Practices and Coding Standards

The project adopts best practices in software development, including coding standards such as PSR-4 for autoloading and PSR-12 for code style.

## Author

- **Andrei Santana**
  - [LinkedIn](https://www.linkedin.com/in/andreisantana/)
  - Email: <andreisantana@gmail.com>
