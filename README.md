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

5. **Seed the Database**

    ```sh
    docker-compose exec app db:seed
    ```

6. **Create a Passport client**

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
```
## Using the Access Token

The access_token returned from `/oauth/token` should be saved and used in all subsequent API requests. The headers for API requests should be:

- Accept: application/json
- Authorization: Bearer {{access_token}}
- Content-Type: application/json (optional if there is a body being sent)

## API Endpoints

The application provides the following endpoints for managing hotels:

### Fields Description

- **Hotel Name**: `string` - The name of the hotel.
- **Country**: `string` - The country where the hotel is located (must follow ISO country code format).
- **City**: `string` - The city where the hotel is located.
- **Price**: `numeric` - The price per night at the hotel.
- **facilities**: `array` - An array of facility names associated with the hotel. Each facility is represented by a `string`.

### Example API Calls

#### 1. Get All Hotels

**Endpoint:** `GET /hotels`

**Description:** Retrieves a list of all hotels, optionally sorted by `Hotel Name`, `Country`, `City`, or `Price`.

**Headers:**

- `accept: application/json`
- `authorization: Bearer {{access_token}}`

**Example Request:**

```sh
curl -X GET http://localhost:8080/hotels \
    -H "accept: application/json" \
    -H "authorization: Bearer {{access_token}}"
```
#### 2. Create a New Hotel

**Endpoint:** `POST /hotels`

**Description:** Creates a new hotel entry.

**Request Body:**

```json
{
    "Hotel Name": "Grand Plaza",
    "Country": "US",
    "City": "New York",
    "Price": 200,
    "facilities": ["WIFI", "Hot Water"]
}
```

**Headers:**

- `accept: application/json`
- `authorization: Bearer {{access_token}}`
- `content: application/json`

**Example Request:**

```sh
curl -X POST http://localhost:8080/hotels \
    -H "accept: application/json" \
    -H "authorization: Bearer {{access_token}}" \
    -H "content: application/json" \
    -d '{
        "Hotel Name": "Grand Plaza",
        "Country": "US",
        "City": "New York",
        "Price": 200,
        "facilities": ["WIFI", "Hot Water"]
    }'
```

#### 3. Get a Specific Hotel

**Endpoint:** `GET /hotels/{id}`

**Description:** Retrieves a specific hotel by its ID.

**Headers:**

- `accept: application/json`
- `authorization: Bearer {{access_token}}`

**Example Request:**

```sh
curl -X GET http://localhost:8080/hotels/1 \
    -H "accept: application/json" \
    -H "authorization: Bearer {{access_token}}"
```

#### 4. Update a Hotel

**Endpoint:** `PUT /hotels/{id}`

**Description:** Updates the details of a specific hotel.

**Request Body:**

```json
{
    "Hotel Name": "Grand Plaza Deluxe",
    "Country": "US",
    "City": "New York",
    "Price": 250,
    "facilities": ["WIFI", "Hot Water", "Pool"]
}
```

**Headers:**

- `accept: application/json`
- `authorization: Bearer {{access_token}}`
- `content: application/json`

**Example Request:**

```sh
curl -X PUT http://localhost:8080/hotels/1 \
    -H "accept: application/json" \
    -H "authorization: Bearer {{access_token}}" \
    -H "content: application/json" \
    -d '{
        "Hotel Name": "Grand Plaza Deluxe",
        "Country": "US",
        "City": "New York",
        "Price": 250,
        "facilities": ["WIFI", "Hot Water", "Pool"]
    }'
```

#### 5. Delete a Hotel

**Endpoint:** `DELETE /hotels/{id}`

**Description:** Deletes a specific hotel by its ID.

**Headers:**

- `accept: application/json`
- `authorization: Bearer {{access_token}}`

**Example Request:**

```sh
curl -X DELETE http://localhost:8080/hotels/1 \
    -H "accept: application/json" \
    -H "authorization: Bearer {{access_token}}"
```