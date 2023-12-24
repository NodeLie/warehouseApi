##################
# Variables
##################

DOCKER_COMPOSE = docker-compose -f ./docker/docker-compose.yml
DOCKER_COMPOSE_PHP_FPM_EXEC = ${DOCKER_COMPOSE} exec -u www-data php-fpm

##################
# Docker compose
##################

build:
	${DOCKER_COMPOSE} build

start:
	${DOCKER_COMPOSE} start

stop:
	${DOCKER_COMPOSE} stop

up:
	${DOCKER_COMPOSE} up -d --remove-orphans

down:
	${DOCKER_COMPOSE} down

restart: stop start
rebuild: down build up

##################
# App
##################

app_bash:
	${DOCKER_COMPOSE} exec -u www-data php-fpm bash
php: app_bash

##################
# Database
##################

db_migrate:
	${DOCKER_COMPOSE} exec -u www-data php-fpm bin/console doctrine:migrations:migrate --no-interaction
migrate: db_migrate

db_diff:
	${DOCKER_COMPOSE} exec -u www-data php-fpm bin/console doctrine:migrations:diff --no-interaction
diff: db_diff

db_schema_validate:
	${DOCKER_COMPOSE} exec -u www-data php-fpm bin/console doctrine:schema:validate

db_migration_down:
	${DOCKER_COMPOSE} exec -u www-data php-fpm bin/console doctrine:migrations:execute "App\Shared\Infrastructure\Database\Migrations\Version********" --down --dry-run

db_drop:
	if exist pgdata rmdir /s /q pgdata
# docker-compose -f ./docker/docker-compose.yml exec -u www-data php-fpm bin/console doctrine:schema:drop --force
