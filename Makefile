first-init:
	make up
	make composer-install
	make fetch-episodes
	make codeception-build

up:
	docker-compose up -d --build

composer-install:
	docker-compose exec php composer install

clear-cache:
	docker-compose exec php ./bin/console cache:clear

fetch-episodes:
	docker-compose exec php bin/console cli:episodes:fetch

psalm:
	docker-compose exec php ./vendor/bin/psalm

csfix:
	docker-compose exec php ./vendor/bin/php-cs-fixer fix

codeception-build:
	docker-compose exec php ./vendor/bin/codecept build

codeception-run:
	docker-compose exec php ./vendor/bin/codecept run
