up:
	docker-compose up -d

down:
	docker-compose stop

shell:
	docker exec -it gprocess-app bash

check:
	./vendor/bin/grumphp run --testsuite=style
