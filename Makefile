install:
	docker compose run -it --rm php composer install

php_example:
	docker compose run -it --rm php php example/example.php

shell:
	docker compose run -it --rm php sh
