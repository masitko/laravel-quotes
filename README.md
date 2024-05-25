### Laravel Quotes API

This project comes with a local Docker environment utilisig [Laravel Sail](https://laravel.com/docs/11.x/sail#rebuilding-sail-images)

### How to use it

1. Clone the repository

2. Run "composer install" inside the cloned repository folder or use the command below to run the command inside the docker container:
```

docker run --rm --interactive --tty -v $(pwd):/app composer install

```
3. Check the .env file - you can change the exposed ports at the bottom of the file using:
```

PORT_PREFIX=16

```
this will expose the API access on localhost on port 16080, and Redis on port 16379

4. Start docker compose by using sail command:
```

./vendor/bin/sail up -d

```
5. The default api prefix is /api/v1. There are two routes available:

**/api/v1/quotes**

(only GET method available) - this will populate 5 quotes from the quote manager using a default 'kayne-west' quote driver (they are going to be populated from external API on the first request and then cached in Redis)

**/api/v1/quotes/refresh**

(only PUT method available) - this will delete quotes from the cache and populate new ones from the external API


**to use the API please add 'Authorization' header to the request with a token defined in .env file:**

```

# in a production environment this should be more secure, moved to .env.production or similar, not to be committed to the repo

AUTHORIZATION_TOKEN="my-secret-token-123"

```

All requests without a token will be denied.

6. To start tests run:

```

./vendor/bin/sail test

```

7. Configuration

  You can change the quotes driver and amount of quotes in config/quotes.php file


8. Contact

  In case of any question email me at [masitko@gmail.com](mailto:masitko@gmail.com)
