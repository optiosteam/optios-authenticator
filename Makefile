tests:
	bin/phpunit

install:
	composer install

.PHONY: tests install
