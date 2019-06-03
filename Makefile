PACKAGE_NAME:=$(notdir $(CURDIR))
PHP_NAMESPACE:=$(shell echo $(PACKAGE_NAME) | php -n -r 'echo(implode(array_map("ucfirst",explode("-",fgets(STDIN)))));')

check: cs stan ## (PHP) Launch all lint tools. A good choice for pre-commit hook

cs: vendor/bin ## (PHP) Code style checker
	@echo
	vendor/bin/php-cs-fixer fix -v --dry-run --allow-risky=yes --using-cache=no src/

fix: vendor/bin ## (PHP) Code style fixer
	@echo
	vendor/bin/php-cs-fixer fix --verbose --allow-risky=yes src/

stan: vendor/bin ## (PHP) Static analysis
	@echo
	vendor/bin/phpstan analyse -l 7 src

test: unit ## (PHP) Launch all test tools

unit: vendor/bin ## (PHP) Unit tests
	@echo
	vendor/bin/phpunit tests/

vendor/bin: ## (PHP) Install dependencies
	@echo
	composer install

init: src/ tests/ composer.json ## Init the project

src/:
	mkdir src

tests/:
	mkdir tests

composer.json:
	composer init\
	 	--name "wizaplace/$(PACKAGE_NAME)"\
	 	--author "Wizaplace <dev@wizaplace.com>"\
		--type "library"\
		--homepage "https://github.com/wizaplace/$(PACKAGE_NAME)"\
		--require-dev "friendsofphp/php-cs-fixer"\
		--require-dev "phpstan/phpstan"\
		--require-dev phpunit/phpunit\
		--stability "stable"\
		--license "MIT"
	cp composer.json composer.json.orig
	cat composer.json.orig | jq --indent 4 '. + {"autoload": {"psr-4": {"Wizaplace\\$(PHP_NAMESPACE)\\": "src/"}}} + {"autoload-dev": {"psr-4": {"Wizaplace\\Test\\$(PHP_NAMESPACE)\\": "tests/"}}} + {"config": {"sort-packages": true}}' > composer.json
	rm composer.json.orig
	composer validate --strict
