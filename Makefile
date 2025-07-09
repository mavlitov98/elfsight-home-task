first-init:
	make up
	make composer-install
	make fetch-episodes

up:
	docker-compose up -d --build

composer-install:
	docker-compose exec php composer install

fetch-episodes:
	docker-compose exec php bin/console cli:episodes:fetch
