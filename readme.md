# Lumen base API

Initial structure as a starting point for the development of an API in PHP with Lumen & Dingo.

## Requirements

* [Composer](https://getcomposer.org/)

## Setup

Clone repository

```shell
$ composer install
$ php artisan jwt:secret
$ php artisan key:generate
```

Copy .env.example file to .env and set your needed environment variables, like database credentials:

Set `API_PREFIX` parameter within the .env file i.e: `API_PREFIX=v1`

## Local Development Server

If you have PHP installed locally and you would like to use PHP's built-in development server to serve your application you may use the artisan `serve` command. This command will start a development server at `http://127.0.0.1:8000`:

```shell
$ php artisan serve
```

## Documentation

This app depends on various projects, if you are having some troubles read the project's docs and if you can't solve it [leave an issue](https://github.com/chispahub/base-lumen-api/issues).

* [Composer](https://getcomposer.org/): used to handle the php dependencies.
* [JWT Auth](https://github.com/tymondesigns/jwt-auth) for Lumen Application.
* [Dingo](https://github.com/dingo/api) to easily and quickly build your own API.
* [Lumen](https://github.com/flipboxstudio/lumen-generator) Generator to make development even easier and faster.
* [Dingo Adapter](https://github.com/durimjusaj/lumen-dingo-adapter) Using Dingo + JWT in your Lumen Based Application with no pain.

## License

The Lumen framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
