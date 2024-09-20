
# Teams-app Backend

A teams backend api used to authenticate user (login and register), show user profile. User can initiate chat, check history of conversation and user can update message only once and can also delete messages.

Postman collection [link](https://api.postman.com/collections/18412970-3a4378bf-eb64-4286-9236-dd636112328f?access_key=PMAT-01J7ZXA4R3NXET9FME64S8DD12)
## API Reference

#### Get the user register

```http
  POST /api/auth/register
```

| Parameter              | Type     | Description          |
| :--------------------  | :------- | :------------------- |
| `name`                 | `string` | **Required**.        |
| `email`                | `string` | **Required**.        |
| `password`             | `string` | **Required**.        |
| `password_confirmation`| `string` | **Required**.        |

#### Get user login

```http
  POST /api/auth/login
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `password`    | `string` | **Required**.                     |
| `email`   | `string` | **Required**.                     |

#### Get user profile

```http
  GET  /api/user/profile
```
Headers
| Parameter        | Type                  | Description   |
| :--------        | :------------------   | :-------------|
| `accept`         | `application/json`    | **Required**. |
| `authorization`  | `Bearer` Token        | **Required**. |

#### Get user logout

```http
  GET  /api/user/logout
```
Headers
| Parameter        | Type                  | Description   |
| :--------        | :------------------   | :-------------|
| `accept`         | `application/json`    | **Required**. |
| `authorization`  | `Bearer` Token        | **Required**. |

#### Get user search

```http
  GET  /api/user/search/{query}
```
Headers
| Parameter        | Type                  | Description   |
| :--------        | :------------------   | :-------------|
| `accept`         | `application/json`    | **Required**. |
| `authorization`  | `Bearer` Token        | **Required**. |

#### Get user search

```http
  GET  /api/user/search/{query}
```
Headers
| Parameter        | Type                  | Description   |
| :--------        | :------------------   | :-------------|
| `accept`         | `application/json`    | **Required**. |
| `authorization`  | `Bearer` Token        | **Required**. |

#### Send Messages from one user to another

```http
  POST  /api/message/create
```
Headers
| Parameter        | Type                  | Description   |
| :--------        | :------------------   | :-------------|
| `accept`         | `application/json`    | **Required**. |
| `authorization`  | `Bearer` Token        | **Required**. |

Body
| Parameter       | Type               | Description          |
| :-------------- | :----------------  | :------------------- |
| `message`       | `string`           | **Required**.        |
| `receiver_id`   | `string`               | **Required**.        |
| `type`          | `enum individual,group` | **Required**.        |

#### Display message

```http
  GET  /api/message/{message_id}
```
Headers
| Parameter        | Type                  | Description   |
| :--------        | :------------------   | :-------------|
| `accept`         | `application/json`    | **Required**. |
| `authorization`  | `Bearer` Token        | **Required**. |

#### Get message update

```http
  PUT  /api/message/update
```
Headers
| Parameter        | Type                  | Description   |
| :--------        | :------------------   | :-------------|
| `accept`         | `application/json`    | **Required**. |
| `authorization`  | `Bearer` Token        | **Required**. |

Body
| Parameter        | Type                  | Description   |
| :--------        | :------------------   | :-------------|
| `message_id`     | `string`                | **Required**. |
| `message`        | `message`             | **Required**. |

#### Get message delete

```http
  DELETE  /api/message/delete
```
Headers
| Parameter        | Type                  | Description   |
| :--------        | :------------------   | :-------------|
| `accept`         | `application/json`    | **Required**. |
| `authorization`  | `Bearer` Token        | **Required**. |

Body
| Parameter        | Type                  | Description   |
| :-------------   | :------------------   | :-------------|
| `message_id`     | `string`                | **Required**. |






## Run Locally

Clone the project

```bash
  git clone https://github.com/arihant-getgrahak/teams-backend-laravel
```

Go to the project directory

```bash
  cd teams-backend-laravel
```

Install dependencies

```bash
  composer install
```

Migrate data to database

```bash
  php artisan migrate
```

Start the server

```bash
  herd open || php artisan serve
```


## Response Schema

[POSTMAN](https://api.postman.com/collections/37798694-120193c7-c882-469e-9dd9-22fa46b2b250?access_key=PMAT-01J7ZSM2M82S3PZKY8PGDH413X)

## Tech Stack

**Client:** PHP, Laravel, Reverb

**Server:** Herd

## Required
PHP version 8.3


## Documentation

[Herd](https://herd.laravel.com/docs/windows/1/getting-started/about-herd)

[Laravel](https://laravel.com/docs/11.x/installation)

[Reverb](https://laravel.com/docs/11.x/reverb)

## Contributing

1. [@arihant-getgrahak](https://github.com/arihant-getgrahak)
2. [@sonaljain01](https://github.com/sonaljain01)

