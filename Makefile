start:
	php artisan serve --host 0.0.0.0

start-local:
	php artisan serve

setup:
	composer install
	cp -n .env.example .env
	php artisan key:generate
	touch database/database.sqlite
	php artisan migrate
	php artisan db:seed

test:
	php artisan test
