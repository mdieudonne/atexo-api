start:
	@docker-compose up --build;

install:
	@docker-compose exec -T php composer install;
	@docker-compose exec -T php php bin/console assets:install --symlink

test:
	@docker-compose exec -T php php ./vendor/bin/phpunit;
