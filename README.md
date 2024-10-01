# Laravel Permissions Example

## Requirements

- Docker

## Local setup

### 1. Configure environment

```
$ cp .env.base .env
$ cp docker-compose.yml.base docker-compose.yml
$ docker compose build php-apache
$ docker compose build
```

Install the recommended extension "Remote Development" in VSCode.

Run command <kbd>Ctrl</kbd> + <kbd>Shift</kbd> + <kbd>P</kbd>:

```
> Dev Container: Rebuild and Reopen in Container
```

### 2. Setup Laravel

```
$ cp .env.example .env
$ php artisan key:generate
$ php artisan storage:link
$ php artisan migrate:fresh --seed
```
