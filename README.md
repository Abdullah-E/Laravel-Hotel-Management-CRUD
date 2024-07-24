# Laravel Application with Docker

This repository contains a Laravel application set up to run with Docker. Follow the instructions below to get the application up and running.

## Prerequisites

- Docker
- Docker Compose

## Getting Started

1. **Clone the repository**

    ```sh
    git clone https://github.com/Abdullah-E/Laravel-Hotel-Management-CRUD.git
    cd Laravel-Hotel-Management-CRUD
    ```

2. **Start Docker containers**

    ```sh
    docker-compose up -d
    ```


3. **Install Composer dependencies**

    ```sh
    docker-compose exec app composer install
    ```

4. **Run database migrations**

    ```sh
    docker-compose exec app php artisan migrate
    ```

5. **Create a Passport client**

    ```sh
    docker-compose exec app php artisan passport:client --client
    ```

    Save the generated `Client ID` and `Client Secret` for API access.

## API Authentication

To authenticate and get an access token, send a POST request to the `/oauth/token` endpoint with the following parameters:

- `grant_type`: The grant type (e.g., `client_credentials`).
- `client_id`: The client ID generated in the previous step.
- `client_secret`: The client secret generated in the previous step.

Example request using cURL:

```sh
curl -X POST l http://localhost:8080/oauth/token \
    -d "grant_type=client_credentials" \
    -d "client_id=CLIENT_ID" \
    -d "client_secret=CLIENT_SECRET" \
