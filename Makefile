.DEFAULT_GOAL 		:= 	clear_cache
.PHONY				:	setup install
DOCKER 				= 	docker
DOCKER_COMPOSE 		= 	docker-compose
DOCKER_APP_ID		=	$(shell $(DOCKER_COMPOSE) ps -q app)
DOCKER_APP_EXEC		=	$(DOCKER) exec $(DOCKER_APP_ID)
DOCKER_APP_CONSOLE	=	$(DOCKER_APP_EXEC) php bin/console

install: # Vendor install
	$(DOCKER_APP_EXEC) composer install

update_database:
	$(DOCKER_APP_CONSOLE) doctrine:schema:update -f

clear_cache: #This is the default action
	$(DOCKER_APP_CONSOLE) cache:clear

image_cache:
	$(DOCKER_APP_CONSOLE) sulu:media:format:cache:clear

docker_setup:
	$(DOCKER) container stop $(shell docker container ls -q)
	$(DOCKER_COMPOSE) up -d

setup: docker_setup install
	printf "DATABASE_URL=mysql://root:sulu@db:3306/sulu\nAPP_ENV=dev" > .env.local
	$(DOCKER_APP_CONSOLE) sulu:build dev
	npm install --prefix assets/website

enter:
	$(DOCKER) exec -it $(DOCKER_APP_ID) bash

clear_git:
	rm -rf .git/* && git init && git add . && git commit -m "Initial commit"
	git remote add origin ssh://git@lab.comsa.be:7685/Websites/$(repository).git

dev:
	npm run dev --prefix assets/website