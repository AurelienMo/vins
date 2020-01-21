CONTAINER_NAME = vins
NETWORK_NAME = vins_default
DOCKER_COMPOSE = docker-compose
DOCKER = docker
USER_DOCKER = $$(id -u $${USER}):$$(id -g $${USER})
DOCKER_PHP = $(DOCKER) exec -u $(USER_DOCKER) -it $(CONTAINER_NAME)_php-fpm sh -c
DOCKER_NPM = $(DOCKER) exec -it $(CONTAINER_NAME)_nodejs sh -c
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
dev: npm-dev
watch: npm-watch
prod: npm-prod
pp: vendor node_modules migrations-migrate cache-clear cache-warmup #Post pull command
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
start: ## Start environnement docker.
start: docker-compose.yml
	$(DOCKER_COMPOSE) up -d --build
	make dx


chown-npm: ## Chown folder /.npm if access denied
chown-npm:
	$(DOCKER) exec -it $(CONTAINER_NAME)_nodejs sh -c "mkdir /.npm"
	$(DOCKER) exec -it $(CONTAINER_NAME)_nodejs sh -c "chown -R $(USER_DOCKER) /.npm"

init: ## Initialize project
init:
	make start
	make vendor
	$(SYMFONY)assets:install
	make cache-clear
	$(DOCKER_NPM) "npm install"
	make dev

destroy: ## Destroy all containers & network
destroy:
	$(DOCKER_COMPOSE) down

stop: ## Stop all containers
stop:
	$(DOCKER_COMPOSE) stop

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

exec-node: ## Exec command inside container nodejs. Use argument ARGS
exec-node:
	$(DOCKER_NPM) "${ARGS}"

connect-php: ## Connect sh to container php
connect-php:
	$(DOCKER) exec -u $(USER_DOCKER) -it $(CONTAINER_NAME)_php-fpm sh

connect-node: ## Connect sh to container nodejs
connect-node:
	$(DOCKER) exec -u $(USER_DOCKER) -it $(CONTAINER_NAME)_nodejs sh

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
	$(DOCKER_NPM) "npm install --ignore-scripts"

new-node_modules: ## Add dependency or dev dependency for npm usage. Use argument ARGS (Example : make new-node_modules ARGS="bootstrap --save") or with --save-dev
new-node_modules: package.json
	$(DOCKER_NPM) "npm install ${ARGS}"

dump-autoload: ## Optimize autoloading and vendor
dump-autoload: composer.lock
	$(DOCKER_PHP) "composer dump-autoload"

##
## Symfony Command
## -------
##

symfony-cmd: ## Exec command symfony inside php container. Use argument ARGS to define command. Example : make symfony-cmd ARGS="assets:install"
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
migrations-migrate:
	$(DOCKER_PHP) "php bin/console doctrine:migrations:migrate -n"

fixtures-load: ## Load fixtures
fixtures-load:
	$(DOCKER_PHP) "php bin/console doctrine:fixtures:load -n"

##
## Tools
## -------
##

xdebug-enable: ## Enable Xdebug
xdebug-enable:
	$(DOCKER) exec -it $(CONTAINER_NAME)_php-fpm sh -c "sed -i 's#;zend_extension=/usr/local/lib/php/extensions/no-debug-non-zts-20180731/xdebug.so#zend_extension=/usr/local/lib/php/extensions/no-debug-non-zts-20180731/xdebug.so#g' /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini"
	$(DOCKER) restart $(CONTAINER_NAME)_php-fpm
	$(DOCKER) restart $(CONTAINER_NAME)_apache

xdebug-disable: ## Disable Xdebug
xdebug-disable:
	$(DOCKER) exec -it $(CONTAINER_NAME)_php-fpm sh -c "sed -i 's#zend_extension=/usr/local/lib/php/extensions/no-debug-non-zts-20180731/xdebug.so#;zend_extension=/usr/local/lib/php/extensions/no-debug-non-zts-20180731/xdebug.so#g' /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini"
	$(DOCKER) restart $(CONTAINER_NAME)_php-fpm
	$(DOCKER) restart $(CONTAINER_NAME)_apache


phpcs: ## Run phpcs
phpcs: vendor/bin/phpcs
	$(DOCKER_PHP) "vendor/bin/phpcs"

phpstan: ## Run phpstan
phpstan: vendor/bin/phpstan
	$(DOCKER_PHP) "vendor/bin/phpstan analyze src"

phpcbf: ## Run PHPCBF
phpcbf: vendor/bin/phpcbf
	$(DOCKER_PHP) vendor/bin/phpcbf

npm-prod: ## Build npm for production environment
npm-prod: package.json
	sudo chown -R $(USER_DOCKER) public
	$(DOCKER_NPM) "npm run prod"

npm-watch: ## Build npm for watch
npm-watch: package.json
	sudo chown -R $(USER_DOCKER) public
	$(DOCKER_NPM) "npm run watch"

npm-dev: ## Build npm for dev environment
npm-dev:
	$(DOCKER_NPM) "npm run dev"

##
## TESTS
## ------
##
test-unit: ## Run phpunit
test-unit: tests
	$(DOCKER_PHP) "vendor/bin/phpunit"
test-functional: ## Run behat
test-functional: features
	$(DOCKER_PHP) "vendor/bin/behat"
