#!/bin/sh
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan migrate:refresh
docker-compose exec app php artisan db:seed
