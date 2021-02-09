start:
	@docker-compose up --build;

install:
	@docker-compose exec -T php composer install;

test:
	@docker-compose exec -T php php ./vendor/bin/phpunit;
