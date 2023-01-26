#! /usr/bin/make

run:
	cp .env.example .env
	docker-compose up -d --build --force-recreate
	docker exec -t jibimo-php bash -c "composer install;php artisan key:generate;php artisan migrate:fresh --seed;"
php:
	docker exec -it jibimo-php bash
