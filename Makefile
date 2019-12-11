CONTAINER_NAME = vins
NETWORK_NAME = vins_default
DOCKER_COMPOSE = docker-compose
DOCKER = docker
USER_DOCKER = $$(id -u $${USER}):$$(id -g $${USER})
DOCKER_PHP = $(DOCKER) exec -u $(USER_DOCKER) -it $(CONTAINER_NAME)_php-fpm sh -c
DOCKER_NPM = $(DOCKER) exec -u $(USER_DOCKER) -it $(CONTAINER_NAME)_nodejs sh -c
SYMFONY = $(DOCKER_PHP) "php bin/console ${ARGS}"


##
## ALIAS
## -------
##

ex: xdebug-enable
dx: xdebug-disable
cc: cache-clear
cw: cache-warmup
cs: phpcs
stan: phpstan
cbf: phpcbf
quality: phpcs phpcbf
test: test-functional phpstan phpcs
build-dev: dev
build-watch: watch
pp: vendor node_modules migrations-exec cache-clear cache-warmup
sf-cmd: symfony-cmd


##
## Project
## -------
##

.DEFAULT_GOAL := help

help: ## Default goal (display the help message)
help:
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-20s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

.PHONY: help

##
## Docker
## -------
##
start: ## Start environnement docker. Build docker env and init project (composer install)
init: docker-compose.yml
	$(DOCKER_COMPOSE) up -d --build
	$(DOCKER_PHP) "composer install"
	$(SYMFONY ARGS="assets:install")

stop: ## Stop environnement docker
stop:
	$(DOCKER_COMPOSE) down

list-containers: ## List container docker
list-containers:
	$(DOCKER_COMPOSE) ps

list-network: ## List all networks on host
list-network:
	$(DOCKER) network ls

inspect-network: ## Inspect current network to list all container ips
inspect-network:
	$(DOCKER) network inspect $(NETWORK_NAME)

erase-all: ## Careful, erase all container, all images
erase-all:
	$(DOCKER) stop $$(docker ps -a -q) && $(DOCKER) rm $$(docker ps -a -q) $(DOCKER) rmi $$(docker images -a -q) -f

exec-php: ## Exec command inside container php. Use argument ARGS
exec-php:
	$(DOCKER_PHP) "${ARGS}"

##
## Manage dependencies
## -------
##

vendor: ## Install composer dependencies
vendor: composer.lock
	$(DOCKER_PHP) "composer install"

new-vendor: ## Add dependency or dev dependency. Use argument ARGS (Example : make new-vendor ARGS="security form" or make new-vendor ARGS="profiler --dev"
new-vendor: composer.json
	$(DOCKER_PHP) "composer require ${ARGS}"

node_modules: ## Install npm dependencies
node_modules: package-lock.json
	$(DOCKER_NPM) "yarn install"

new-node_modules: ## Add dependency or dev dependency for npm usage. Use argument ARGS (Example : make new-node_modules ARGS="bootstrap --save") or with --save-dev
new-node_modules: package.json
	$(DOCKER_NPM) "yarn install ${ARGS}"

optimize-composer: ## Optimize autoloading and vendor
optimize-composer: composer.lock
	$(DOCKER_PHP) "composer dump-autoload -o -a"

##
## Symfony Command
## -------
##

symfony-cmd: ## Exec command symfony inside php container. Use argument ARGS to define command. Example : make symfony-cmd "assets:install"
symfony-cmd:
	$(SYMFONY)

cache-clear: ## Clear the cache (by default, the dev env is used, use ARGS argument to change)
cache-clear:
	$(DOCKER_PHP) "php bin/console cache:clear --env=$(or $(ARGS), dev)"

cache-warmup: ## Clear the cache warmup (by default, the dev env is used, use ARGS arguement to change)
cache-warmup:
	$(DOCKER_PHP) "php bin/console cache:warmup --env=$(or $(ARGS), dev)"

migrations-diff: ## Generate diff migrations doctrine
migrations-diff:
	$(DOCKER_PHP) "php bin/console doctrine:migrations:diff"

migrations-exec: ## Execute migrations
migrations-exec:
	$(DOCKER_PHP) "php bin/console doctrine:migrations:migrate"

##
## Tools
## -------
##

phpcs: ## Run phpcs
phpcs: vendor/bin/phpcs
	$(DOCKER_PHP) "vendor/bin/phpcs"

phpstan: ## Run phpstan
phpstan: vendor/bin/phpstan
	$(DOCKER_PHP) "vendor/bin/phpstan analyze src"

phpcbf: ## Run PHPCBF
phpcbf: vendor/bin/phpcbf
	$(DOCKER_PHP) vendor/bin/phpcbf

prod: ## Build npm for production environment
prod: package.json
	$(DOCKER_NPM) yarn run prod

watch: ## Build npm for watch
watch: package.json
	$(DOCKER_NPM) yarn run watch

dev: ## Build npm for dev environment
dev:
	$(DOCKER_NPM) yarn run dev

##
## TESTS
## ------
##
test-unit: ## Run phpunit
test-unit: tests
	vendor/bin/phpunit
test-functional: ## Run behat
test-functional: features
	vendor/bin/behat
