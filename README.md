# Symfony URL Shortener

URL Shortener project built in symfony

## Class-diagram

Below an approximate example of the main architecture used in the application

![Workflow](/docs/workflow.png)

## Used Stack

**Front-end**: symfony/form

**Back-end**: Symfony 6; PHP 8.1; MySQL 5.7;

**Test**: SQLite;

**Development environment**: Docker 20.10; docker-compose 1.29; composer 2.4;

Tip) If you are using Linux distros (especially Ubuntu 20.x), we recommend you do not use `snap` to install docker as it may give you some headaches with `apparmor`. Use `apt` installer instead.

## Installing

First of all clone the project on you local!

**IMPORTANT**: We recommend you ensure you have the `rstriquer/php-fpm.dev:8.1-dev` and `mysql:5.7` images on your local before proceeding.

To check if you have them, use the `docker image list` command and check if they are in the list. If they are not, use the commands below to download them to your local.

```bash
docker pull mysql:5.7
```

**IMPORTANT**: We recommend you run the above commands time-per-time to ensure your local images are up to date according to `hub.docker.com` server.

Ok, if you have docker and an up to date image ... just give it a first run to load the environment and build your database! Remember to wait it to show you a messagem "MySQL sh-99: Done database creation ..." saying it has finished configuring the database environment.

Then (once you have initialized the containers, as described in "Running the dev environment") run the system migrations as stated below on the project home directory.

```bash
composer install
bin/console doctrine:schema:create
bin/console doctrine:migrations:migrate
```

### If anything goes wrong on installation

#### Grant database privileges

If when running the container initialization command you notice that mysql did not create the user, or when running the migration command it presented you with an error message. Run the command below as the root user. It is possible that for some reason the user did not receive the appropriate privilege;

```bash
GRANT ALL PRIVILEGES ON url_shortener_dev.* TO 'someuser'@'%' IDENTIFIED BY '123456';
```

#### Clear caches

To clear symfony caches from the project home directory it is recommended to ...

```bash
./bin/console cache:pool:clear --all && \
    ./bin/console cache:clear && \
    ./bin/console cache:clear --env=test
```

To clear Doctrine cache you just run ...

```bash
./bin/console doctrine:cache:clear-metadata && \
  ./bin/console doctrine:cache:clear-query && \
  ./bin/console doctrine:cache:clear-result
```

# Running the app

## Dev env

The environment is composed of a local mysql container to facilitate the configuration of the database in the var directory (so you know that the database is there and it is easier to delete it. Ensure that you also deleted the database repository when deleting the project from the local disk ) and to run the project, just run the symfony command available in the project with the command `./bin/symfony server:start` and the system will be available in your local environment.

## Unit testing

To run the unit tests at the project run the command `SYMFONY_DEPRECATIONS_HELPER=weak ./bin/phpunit --exclude-group ignore`.

# License

[MIT](https://choosealicense.com/licenses/mit/)
