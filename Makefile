first-init:
	make up
	make composer-install
	make create-db
	make migrations-run
	make fetch-episodes
	make codeception-build
	make codeception-run

up:
	docker-compose up -d --build

composer-install:
	docker-compose exec php composer install

clear-cache:
	docker-compose exec php ./bin/console cache:clear

fetch-episodes:
	docker-compose exec php bin/console cli:episodes:fetch

create-db:
	docker-compose exec php bin/console doctrine:database:create

migrations-run:
	docker-compose exec php bin/console doctrine:migrations:migrate --no-interaction

psalm:
	docker-compose exec php ./vendor/bin/psalm

csfix:
	docker-compose exec php ./vendor/bin/php-cs-fixer fix

codeception-build:
	docker-compose exec php ./vendor/bin/codecept build

codeception-run:
	docker-compose exec php ./vendor/bin/codecept run
