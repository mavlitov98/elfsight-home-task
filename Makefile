first-init:
	make up
	make composer-install

up:
	docker-compose up -d --build

composer-install:
	docker-compose exec php composer install
