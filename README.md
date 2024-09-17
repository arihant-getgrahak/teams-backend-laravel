
# Teams-app Backend

A Teams app backend which is responsible for the API's, that perform the functionality of chat either it is group or individual message. User is also able to perform the CRUD operations  like create message, update message only once and can also delete messages.


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
| `name`    | `string` | **Required**.                     |
| `email`   | `string` | **Required**.                     |

#### Get user profile

```http
  GET  /api/user/profile
```
``Headers
| Parameter        | Type                  | Description   |
| :--------        | :------------------   | :-------------|
| `accept`         | `application/json`    | **Required**. |
| `authorization`  | `Bearer` Token        | **Required**. |

#### Get user logout

```http
  GET  /api/user/logout
```
``Headers
| Parameter        | Type                  | Description   |
| :--------        | :------------------   | :-------------|
| `accept`         | `application/json`    | **Required**. |
| `authorization`  | `Bearer` Token        | **Required**. |

#### Get user search

```http
  GET  /api/user/search/{query}
```
``Headers
| Parameter        | Type                  | Description   |
| :--------        | :------------------   | :-------------|
| `accept`         | `application/json`    | **Required**. |
| `authorization`  | `Bearer` Token        | **Required**. |

#### Get user search

```http
  GET  /api/user/search/{query}
```
``Headers
| Parameter        | Type                  | Description   |
| :--------        | :------------------   | :-------------|
| `accept`         | `application/json`    | **Required**. |
| `authorization`  | `Bearer` Token        | **Required**. |

#### Send Messages from one user to another

```http
  POST  /api/message/create
```
``Headers
| Parameter        | Type                  | Description   |
| :--------        | :------------------   | :-------------|
| `accept`         | `application/json`    | **Required**. |
| `authorization`  | `Bearer` Token        | **Required**. |

``Body
| Parameter       | Type               | Description          |
| :-------------- | :----------------  | :------------------- |
| `message`       | `string`           | **Required**.        |
| `receiver_id`   | `id`               | **Required**.        |
| `type`          | `individual|group` | **Required**.        |

#### Display message

```http
  GET  /api/message/{message_id}
```
``Headers
| Parameter        | Type                  | Description   |
| :--------        | :------------------   | :-------------|
| `accept`         | `application/json`    | **Required**. |
| `authorization`  | `Bearer` Token        | **Required**. |

#### Get message update

```http
  PUT  /api/message/update
```
``Headers
| Parameter        | Type                  | Description   |
| :--------        | :------------------   | :-------------|
| `accept`         | `application/json`    | **Required**. |
| `authorization`  | `Bearer` Token        | **Required**. |

``Body
| Parameter        | Type                  | Description   |
| :--------        | :------------------   | :-------------|
| `message_id`     | `{id}`                | **Required**. |
| `message`        | `message`             | **Required**. |

#### Get message delete

```http
  DELETE  /api/message/delete
```
``Headers
| Parameter        | Type                  | Description   |
| :--------        | :------------------   | :-------------|
| `accept`         | `application/json`    | **Required**. |
| `authorization`  | `Bearer` Token        | **Required**. |

``Body
| Parameter        | Type                  | Description   |
| :-------------   | :------------------   | :-------------|
| `message_id`     | `{id}`                | **Required**. |






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

