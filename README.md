# Holiday Planner API


## Introduction
This project is a RESTful API using Laravel to manage holiday plans. Its built using MySQL for the database, Passport for authentication and PHPUnit for testing. As for the docker container its built using Sail.

## Requirements
- PHP >= 8.2
- Composer
- MySQL

## Installation
1. Clone the repository:
    ```sh
    git clone https://github.com/elton-tanaka/holiday-planner-api.git
    cd holiday-planner-api
    ```
2. Build and run docker containers
    ```sh
    ./vendor/bin/sail up -d
    ```

3. Install dependencies:
    ```sh
    ./vendor/bin/sail composer install
    ```

4. Copy the `.env.example` file to `.env` and configure your environment variables:
    ```sh
    cp .env.example .env
    ```

5. Generate an application key:
    ```sh
    ./vendor/bin/sail php artisan key:generate
    ```
6. Setup Database:
     ```sh
    ./vendor/bin/sail php artisan migrate
    ```

## API Routes and Endpoints
### User Endpoints
- `POST /api/v1/register` - Register a new user
- `POST /api/v1/login` - Login a user
- `POST /api/v1/logout` - Logout a user (requires authentication)
- `POST /api/v1/holidays/{holidayId}/join` - Join a holiday (requires authentication)

### Holiday Endpoints
- `POST /api/v1/holidays` - Create a holiday
- `PUT /api/v1/holidays/{holidayId}` - Update a holiday
- `DELETE /api/v1/holidays/{holidayId}` - Delete a holiday
- `GET /api/v1/holidays` - Get all holidays
- `GET /api/v1/holidays/{holidayId}` - Get holiday by its ID
- `GET /api/v1/holidays/{holidayId}/pdf` - Generate a pdf file for the holiday

A postman collection is in the root of the project for easy setup.

## Authentication
This project uses Laravel Passport for API authentication. To set up Passport, run the following command:
```sh
    .vendor/bin/sail php artisan passport:install
```

Ensure that the Personal Access Client is created and configured in your .env file.

## Tests
To run the tests, use the following command:
```
    .vendor/bin/sail php artisan test
```
Tests are located in the tests directory and are organized into Feature and Unit tests.

